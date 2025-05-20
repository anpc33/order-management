@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.add_product') }}</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Nhập tên sản phẩm"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">{{ __('messages.price') }}</label>
                    <div class="input-group">
                        <input type="number"
                               class="form-control @error('price') is-invalid @enderror"
                               id="price"
                               name="price"
                               value="{{ old('price') }}"
                               placeholder="Nhập giá sản phẩm"
                               required>
                        <span class="input-group-text">VNĐ</span>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thêm sản phẩm mới</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Nhập tên sản phẩm"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <div class="input-group">
                            <input type="number"
                                   class="form-control @error('price') is-invalid @enderror"
                                   id="price"
                                   name="price"
                                   value="{{ old('price') }}"
                                   placeholder="Nhập giá sản phẩm"
                                   required>
                            <span class="input-group-text">VNĐ</span>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Số lượng</label>
                        <input type="number"
                               class="form-control @error('stock') is-invalid @enderror"
                               id="stock"
                               name="stock"
                               value="{{ old('stock') }}"
                               placeholder="Nhập số lượng"
                               required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
