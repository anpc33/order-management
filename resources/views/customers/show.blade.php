@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin khách hàng</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
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

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Thông tin cơ bản</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted d-block">Mã khách hàng</label>
                                <strong>#{{ $customer->id }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Tên khách hàng</label>
                                <strong>{{ $customer->name }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Số điện thoại</label>
                                <strong>{{ $customer->phone }}</strong>
                            </div>
                            <div>
                                <label class="text-muted d-block">Địa chỉ</label>
                                <strong>{{ $customer->address }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Thông tin bổ sung</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted d-block">Ngày tạo</label>
                                <strong>{{ $customer->created_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Cập nhật lần cuối</label>
                                <strong>{{ $customer->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Lịch sử đơn hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders as $order)
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">#{{ $order->id }}</span>
                                        </td>
                                        <td>{{ number_format($order->total_price) }} VNĐ</td>
                                        <td>
                                            @switch($order->status)
                                                @case('pending')
                                                    <span class="badge bg-warning">Chờ xử lý</span>
                                                    @break
                                                @case('processing')
                                                    <span class="badge bg-info">Đang xử lý</span>
                                                    @break
                                                @case('shipping')
                                                    <span class="badge bg-primary">Đang giao hàng</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}"
                                               class="btn btn-sm btn-info"
                                               data-bs-toggle="tooltip"
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">Chưa có đơn hàng nào</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection
