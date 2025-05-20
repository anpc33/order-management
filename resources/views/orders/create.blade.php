@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.add_order') }}</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Lỗi!</strong> Vui lòng kiểm tra lại thông tin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="customer_id" class="form-label">{{ __('messages.customer') }}</label>
                        <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                            <option value="">{{ __('messages.select_customer') }}</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">{{ __('messages.status') }}</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.order_status_pending') }}</option>
                            <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>{{ __('messages.order_status_processing') }}</option>
                            <option value="shipping" {{ old('status') == 'shipping' ? 'selected' : '' }}>{{ __('messages.order_status_shipping') }}</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.order_status_completed') }}</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('messages.order_status_cancelled') }}</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.products') }}</label>
                    <div id="products-container">
                        <div class="row mb-2 product-row">
                            <div class="col-md-6">
                                <select class="form-select product-select" name="products[0][id]" required>
                                    <option value="">{{ __('messages.select_product') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} - {{ number_format($product->price) }}đ
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control quantity-input" name="products[0][quantity]" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-product">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" id="add-product">
                        <i class="fas fa-plus"></i> {{ __('messages.add_product') }}
                    </button>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('messages.notes') }}</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let productCount = 1;

        $('#add-product').click(function() {
            const newRow = $('.product-row:first').clone();
            newRow.find('select').attr('name', `products[${productCount}][id]`);
            newRow.find('input').attr('name', `products[${productCount}][quantity]`).val(1);
            $('#products-container').append(newRow);
            productCount++;
        });

        $(document).on('click', '.remove-product', function() {
            if ($('.product-row').length > 1) {
                $(this).closest('.product-row').remove();
            }
        });
    });
</script>
@endpush
