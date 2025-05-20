<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $total_price = 0;
            $order_items = [];

            // Tính tổng tiền và kiểm tra tồn kho
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm trong kho.");
                }

                $total_price += $product->price * $item['quantity'];
                $order_items[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ];
            }

            // Tạo đơn hàng
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'total_price' => $total_price,
                'status' => 'pending'
            ]);

            // Tạo các order items
            foreach ($order_items as $item) {
                $order->items()->create($item);

                // Cập nhật số lượng tồn kho
                $product = Product::find($item['product_id']);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Đơn hàng đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Không thể chỉnh sửa đơn hàng đã xử lý.');
        }

        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Không thể chỉnh sửa đơn hàng đã xử lý.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Hoàn trả số lượng tồn kho cũ
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $product->increment('stock', $item->quantity);
            }

            $total_price = 0;
            $order_items = [];

            // Tính tổng tiền và kiểm tra tồn kho mới
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm trong kho.");
                }

                $total_price += $product->price * $item['quantity'];
                $order_items[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ];
            }

            // Cập nhật đơn hàng
            $order->update([
                'customer_id' => $request->customer_id,
                'total_price' => $total_price
            ]);

            // Xóa các order items cũ
            $order->items()->delete();

            // Tạo các order items mới
            foreach ($order_items as $item) {
                $order->items()->create($item);

                // Cập nhật số lượng tồn kho
                $product = Product::find($item['product_id']);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Đơn hàng đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('orders.index')
                ->with('error', 'Không thể xóa đơn hàng đã xử lý.');
        }

        try {
            DB::beginTransaction();

            // Hoàn trả số lượng tồn kho
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $product->increment('stock', $item->quantity);
            }

            // Xóa đơn hàng
            $order->items()->delete();
            $order->delete();

            DB::commit();
            return redirect()->route('orders.index')
                ->with('success', 'Đơn hàng đã được xóa thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi xóa đơn hàng.');
        }
    }

    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
}
