@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h5>
                <div class="d-flex gap-2">
                    @if($order->status === 'pending')
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                    @endif
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
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
                            <h6 class="mb-0">Thông tin khách hàng</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted d-block">Tên khách hàng</label>
                                <strong>{{ $order->customer->name }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Email</label>
                                <strong>{{ $order->customer->email }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Số điện thoại</label>
                                <strong>{{ $order->customer->phone }}</strong>
                            </div>
                            <div>
                                <label class="text-muted d-block">Địa chỉ</label>
                                <strong>{{ $order->customer->address }}</strong>
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
                                <label class="text-muted d-block">Trạng thái</label>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Chờ xử lý</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-info">Đang xử lý</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                        @break
                                @endswitch
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Ngày tạo</label>
                                <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block">Cập nhật lần cuối</label>
                                <strong>{{ $order->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div>
                                <label class="text-muted d-block">Tổng tiền</label>
                                <h4 class="text-primary mb-0">{{ number_format($order->total_price) }} VNĐ</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Chi tiết sản phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="fas fa-box text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">ID: #{{ $item->product->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->price) }} VNĐ</td>
                                        <td class="text-end">{{ number_format($item->price * $item->quantity) }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($order->total_price) }} VNĐ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($order->status === 'pending')
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Cập nhật trạng thái</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select" style="width: auto;">
                                <option value="processing">Đang xử lý</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Hủy đơn hàng</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
