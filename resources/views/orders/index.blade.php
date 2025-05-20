@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.orders') }}</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('messages.add_order') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('messages.order_id') }}</th>
                            <th>{{ __('messages.customer') }}</th>
                            <th>{{ __('messages.total_price') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $order->id }}</span>
                                </td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ number_format($order->total_price) }} VNĐ</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">
                                        {{ __('messages.order_status_' . $order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="{{ __('messages.view') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="{{ __('messages.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="{{ __('messages.delete') }}" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Chưa có đơn hàng nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Hiển thị {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }}
                    trong tổng số {{ $orders->total() }} đơn hàng
                </div>
                {{ $orders->links('vendor.pagination.bootstrap-5') }}
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
