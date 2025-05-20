@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-shopping-cart me-2"></i>{{ __('messages.total_orders') }}
                </h5>
                <h2 class="mb-0">{{ number_format($totalOrders) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-money-bill-wave me-2"></i>{{ __('messages.total_revenue') }}
                </h5>
                <h2 class="mb-0">{{ number_format($totalRevenue) }}đ</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-users me-2"></i>{{ __('messages.total_customers') }}
                </h5>
                <h2 class="mb-0">{{ number_format($totalCustomers) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-box me-2"></i>{{ __('messages.total_products') }}
                </h5>
                <h2 class="mb-0">{{ number_format($totalProducts) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('messages.revenue_by_time') }}</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('messages.order_status') }}</h5>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('messages.top_products') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.quantity_sold') }}</th>
                                <th>{{ __('messages.revenue') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr>
                                <td>{{ $product->product->name }}</td>
                                <td>{{ number_format($product->total_quantity) }}</td>
                                <td>{{ number_format($product->total_quantity * $product->product->price) }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Biểu đồ doanh thu
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyRevenue->pluck('date')) !!},
        datasets: [{
            label: '{{ __("messages.revenue_by_time") }}',
            data: {!! json_encode($dailyRevenue->pluck('revenue')) !!},
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString() + 'đ';
                    }
                }
            }
        }
    }
});

// Biểu đồ trạng thái đơn hàng
const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($orderStatus->pluck('status')) !!},
        datasets: [{
            data: {!! json_encode($orderStatus->pluck('total')) !!},
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
