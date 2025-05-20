@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.customers') }}</h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('messages.add_customer') }}
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
                            <th>{{ __('messages.customer_id') }}</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.phone') }}</th>
                            <th>{{ __('messages.address') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $customer->id }}</span>
                                </td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="{{ __('messages.view') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="{{ __('messages.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
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
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Chưa có khách hàng nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Hiển thị {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }}
                    trong tổng số {{ $customers->total() }} khách hàng
                </div>
                {{ $customers->links('vendor.pagination.bootstrap-5') }}
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
