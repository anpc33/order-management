@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('status'))
                <div class="alert alert-{{ session('status') === 'profile-updated' ? 'success' : 'info' }} alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>{{ __('messages.profile_information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3 text-center">
                            <div class="position-relative d-inline-block">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                     class="rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     alt="Avatar">
                                <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="cursor: pointer;">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key me-2"></i>{{ __('messages.update_password') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('messages.current_password') }}</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('messages.new_password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('messages.update_password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preferences -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>{{ __('messages.preferences') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.preferences') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="language" class="form-label">{{ __('messages.language') }}</label>
                            <select class="form-select @error('language') is-invalid @enderror"
                                    id="language" name="language">
                                <option value="en" {{ auth()->user()->preferences->language === 'en' ? 'selected' : '' }}>English</option>
                                <option value="vi" {{ auth()->user()->preferences->language === 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                <option value="zh" {{ auth()->user()->preferences->language === 'zh' ? 'selected' : '' }}>中文</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="theme" class="form-label">{{ __('messages.theme') }}</label>
                            <select class="form-select @error('theme') is-invalid @enderror"
                                    id="theme" name="theme">
                                <option value="light" {{ auth()->user()->preferences->theme === 'light' ? 'selected' : '' }}>{{ __('messages.light_theme') }}</option>
                                <option value="dark" {{ auth()->user()->preferences->theme === 'dark' ? 'selected' : '' }}>{{ __('messages.dark_theme') }}</option>
                            </select>
                            @error('theme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                       id="notifications" name="notifications"
                                       {{ auth()->user()->preferences->notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="notifications">
                                    {{ __('messages.enable_notifications') }}
                                </label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('messages.save_preferences') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-danger">
                        <i class="fas fa-trash-alt me-2"></i>{{ __('messages.delete_account') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('messages.confirm_password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('{{ __('messages.confirm_delete_account') }}')">
                                <i class="fas fa-trash-alt me-2"></i>{{ __('messages.delete_account') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview avatar before upload
    document.getElementById('avatar').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.rounded-circle').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Theme switcher
    document.getElementById('theme').addEventListener('change', function(e) {
        document.documentElement.setAttribute('data-theme', e.target.value);
    });
</script>
@endpush
@endsection
