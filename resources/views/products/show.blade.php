@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chi tiết sản phẩm</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Sửa sản phẩm
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <div class="bg-light rounded-circle p-4 mx-auto" style="width: 150px; height: 150px;">
                            <i class="fas fa-box fa-4x text-primary"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h4 class="mb-3">{{ $product->name }}</h4>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-secondary me-2">ID: #{{ $product->id }}</span>
                                <span class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Cập nhật: {{ $product->updated_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Giá sản phẩm</h6>
                                        <h3 class="card-title text-primary mb-0">
                                            {{ number_format($product->price) }} VNĐ
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Số lượng tồn kho</h6>
                                        <h3 class="card-title mb-0">
                                            <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                                {{ $product->stock }}
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="text-muted mb-3">Thông tin bổ sung</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 200px;">Ngày tạo</th>
                                            <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lần cập nhật cuối</th>
                                            <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái</th>
                                            <td>
                                                @if($product->stock > 10)
                                                    <span class="badge bg-success">Còn hàng</span>
                                                @elseif($product->stock > 0)
                                                    <span class="badge bg-warning">Sắp hết hàng</span>
                                                @else
                                                    <span class="badge bg-danger">Hết hàng</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
