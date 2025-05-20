@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('messages.add_customer') }}</h2>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Lỗi!</strong> Vui lòng kiểm tra lại thông tin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('messages.phone') }}</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('messages.address') }}</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
