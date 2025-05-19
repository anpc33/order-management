<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo 1 admin và 1 nhân viên
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Nhân viên A',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'staff',
        ]);

        // Tạo 10 sản phẩm
        Product::factory(10)->create();

        // Tạo 5 khách hàng
        Customer::factory(5)->create();

        // Tạo 3 đơn hàng mẫu mỗi đơn có 1–3 sản phẩm
        Customer::all()->take(3)->each(function ($customer) {
            $order = Order::create([
                'customer_id' => $customer->id,
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $products = Product::inRandomOrder()->take(rand(1, 3))->get();
            $total = 0;

            foreach ($products as $product) {
                $qty = rand(1, 5);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                ]);

                $total += $price * $qty;
            }

            $order->update(['total_price' => $total]);
        });
    }
}
