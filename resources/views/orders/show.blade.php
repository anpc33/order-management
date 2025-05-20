@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.order_details') }}</h2>
        <div>
            <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('messages.customer_info') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">{{ __('messages.customer_id') }}</th>
                            <td>{{ $order->customer->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.name') }}</th>
                            <td>{{ $order->customer->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.phone') }}</th>
                            <td>{{ $order->customer->phone }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.address') }}</th>
                            <td>{{ $order->customer->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('messages.order_info') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">{{ __('messages.order_id') }}</th>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.status') }}</th>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ __('messages.order_status_' . $order->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.total_price') }}</th>
                            <td>{{ number_format($order->total_price) }}đ</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.created_at') }}</th>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.updated_at') }}</th>
                            <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('messages.order_items') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('messages.product') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.quantity') }}</th>
                            <th>{{ __('messages.subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->price) }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">{{ __('messages.total') }}</th>
                            <th>{{ number_format($order->total_price) }}đ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @if($order->notes)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('messages.notes') }}</h5>
        </div>
        <div class="card-body">
            {{ $order->notes }}
        </div>
    </div>
    @endif
</div>
@endsection
