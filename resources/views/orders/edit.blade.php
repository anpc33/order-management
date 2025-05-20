@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Chỉnh sửa đơn hàng #{{ $order->id }}</h5>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Lỗi!</strong> Vui lòng kiểm tra lại thông tin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('orders.update', $order->id) }}" method="POST" id="orderForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Thông tin khách hàng</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Chọn khách hàng</label>
                                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn khách hàng --</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ (old('customer_id', $order->customer_id) == $customer->id) ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Thông tin đơn hàng</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Tổng tiền</label>
                                    <h3 class="text-primary mb-0" id="totalPrice">{{ number_format($order->total_price) }} VNĐ</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Chi tiết sản phẩm</h6>
                            <button type="button" class="btn btn-primary btn-sm" id="addProduct">
                                <i class="fas fa-plus"></i> Thêm sản phẩm
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="products">
                            @foreach($order->items as $index => $item)
                                <div class="row product-item mb-3">
                                    <div class="col-md-6">
                                        <select name="items[{{ $index }}][product_id]" class="form-select product-select" required>
                                            <option value="">-- Chọn sản phẩm --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                        data-price="{{ $product->price }}"
                                                        data-stock="{{ $product->stock }}"
                                                        {{ (old("items.{$index}.product_id", $item->product_id) == $product->id) ? 'selected' : '' }}>
                                                    {{ $product->name }} - {{ number_format($product->price) }} VNĐ (Còn: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="items[{{ $index }}][quantity]"
                                               class="form-control quantity-input"
                                               placeholder="Số lượng"
                                               min="1"
                                               value="{{ old("items.{$index}.quantity", $item->quantity) }}"
                                               required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-product">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('products');
    const addProductBtn = document.getElementById('addProduct');
    let productCount = {{ count($order->items) }};

    // Thêm sản phẩm mới
    addProductBtn.addEventListener('click', function() {
        const template = document.querySelector('.product-item').cloneNode(true);
        template.querySelectorAll('select, input').forEach(input => {
            input.value = '';
            input.name = input.name.replace(/\[\d+\]/, `[${productCount}]`);
        });
        productsContainer.appendChild(template);
        productCount++;
        updateTotalPrice();
    });

    // Xóa sản phẩm
    productsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-product')) {
            if (document.querySelectorAll('.product-item').length > 1) {
                e.target.closest('.product-item').remove();
                updateTotalPrice();
            }
        }
    });

    // Cập nhật tổng tiền khi thay đổi sản phẩm hoặc số lượng
    productsContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
            updateTotalPrice();
        }
    });

    // Tính tổng tiền
    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.product-item').forEach(item => {
            const select = item.querySelector('.product-select');
            const quantity = item.querySelector('.quantity-input');
            if (select.value && quantity.value) {
                const price = select.options[select.selectedIndex].dataset.price;
                total += price * quantity.value;
            }
        });
        document.getElementById('totalPrice').textContent = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';
    }

    // Validate form trước khi submit
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        const products = document.querySelectorAll('.product-item');
        let isValid = true;

        products.forEach(item => {
            const select = item.querySelector('.product-select');
            const quantity = item.querySelector('.quantity-input');
            const stock = select.options[select.selectedIndex]?.dataset.stock;

            if (select.value && quantity.value) {
                if (parseInt(quantity.value) > parseInt(stock)) {
                    alert(`Sản phẩm ${select.options[select.selectedIndex].text} chỉ còn ${stock} sản phẩm trong kho.`);
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Khởi tạo tổng tiền
    updateTotalPrice();
});
</script>
@endpush
@endsection
