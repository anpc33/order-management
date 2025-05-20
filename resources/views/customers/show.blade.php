@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.customer_details') }}</h2>
        <div>
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
            </a>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('messages.basic_info') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">{{ __('messages.customer_id') }}</th>
                            <td>{{ $customer->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.name') }}</th>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.phone') }}</th>
                            <td>{{ $customer->phone }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.address') }}</th>
                            <td>{{ $customer->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('messages.additional_info') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">{{ __('messages.created_at') }}</th>
                            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.updated_at') }}</th>
                            <td>{{ $customer->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('messages.order_history') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('messages.order_id') }}</th>
                            <th>{{ __('messages.total_price') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ number_format($order->total_price) }}đ</td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ __('messages.order_status_' . $order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="{{ __('messages.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">{{ __('messages.no_orders') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
