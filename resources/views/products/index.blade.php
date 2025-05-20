@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Quản lý sản phẩm</h5>
                <small class="text-muted">Tổng số sản phẩm: {{ $products->total() }}</small>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sản phẩm..."
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    @if(request('search'))
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </form>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sản phẩm mới
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px;">ID</th>
                        <th>Tên sản phẩm</th>
                        <th class="text-end">Giá</th>
                        <th class="text-center" style="width: 120px;">Số lượng</th>
                        <th class="text-center" style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-secondary">#{{ $product->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-2" style="width: 40px; height: 40px;">
                                        <i class="fas fa-box text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                    <small class="text-muted">Cập nhật: {{ $product->updated_at->format('d/m/Y H:i')
                                        }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <span class="fw-bold">{{ number_format($product->price) }} VNĐ</span>
                        </td>
                        <td class="text-center">
                            <span
                                class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                    title="Sửa sản phẩm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $product->id }}" title="Xóa sản phẩm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa sản phẩm <strong>{{ $product->name }}</strong>?
                                            </p>
                                            <p class="text-danger mb-0"><small>Hành động này không thể hoàn tác.</small>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa sản phẩm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                <p class="mb-0">Không có sản phẩm nào</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Hiển thị {{ $products->firstItem() ?? 0 }} đến {{ $products->lastItem() ?? 0 }} của {{
                $products->total() }} sản phẩm
            </div>
            <div>
                {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush