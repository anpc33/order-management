<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            .navbar-brand {
                font-weight: 600;
            }
            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            .table th {
                background-color: var(--bs-table-bg);
            }
            .btn-icon {
                padding: 0.25rem 0.5rem;
            }
            .nav-link {
                color: rgba(255, 255, 255, 0.9) !important;
            }
            .nav-link:hover {
                color: #fff !important;
            }
            .nav-link.active {
                color: #fff !important;
                font-weight: 500;
            }

            /* Dark mode styles */
            [data-bs-theme="dark"] {
                --bs-body-bg: #212529;
                --bs-body-color: #e9ecef;
            }

            [data-bs-theme="dark"] .card {
                background-color: #2c3034;
                border-color: #373b3e;
            }

            [data-bs-theme="dark"] .table {
                color: #e9ecef;
            }

            [data-bs-theme="dark"] .table-hover tbody tr:hover {
                background-color: #2c3034;
            }

            [data-bs-theme="dark"] .dropdown-menu {
                background-color: #2c3034;
                border-color: #373b3e;
            }

            [data-bs-theme="dark"] .dropdown-item {
                color: #e9ecef;
            }

            [data-bs-theme="dark"] .dropdown-item:hover {
                background-color: #373b3e;
                color: #fff;
            }

            .theme-switch {
                cursor: pointer;
                padding: 0.5rem;
                border-radius: 0.375rem;
                transition: background-color 0.2s;
            }

            .theme-switch:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    @auth
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                   href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                                   href="{{ route('products.index') }}">
                                    <i class="fas fa-box me-1"></i> Sản phẩm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                                   href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i> Đơn hàng
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                                   href="{{ route('customers.index') }}">
                                    <i class="fas fa-users me-1"></i> Khách hàng
                                </a>
                            </li>
                        </ul>
                    @endauth
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <div class="theme-switch nav-link" id="themeSwitch">
                                <i class="fas fa-sun"></i>
                            </div>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-cog me-1"></i> Cài đặt
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            @if (isset($header))
                <div class="mb-4">
                    {{ $header }}
                </div>
            @endif

            <main>
                @yield('content')
            </main>
        </div>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Dark mode script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const themeSwitch = document.getElementById('themeSwitch');
                const html = document.documentElement;
                const icon = themeSwitch.querySelector('i');

                // Kiểm tra theme đã lưu
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    html.setAttribute('data-bs-theme', savedTheme);
                    updateIcon(savedTheme);
                }

                // Xử lý sự kiện click
                themeSwitch.addEventListener('click', function() {
                    const currentTheme = html.getAttribute('data-bs-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    html.setAttribute('data-bs-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    updateIcon(newTheme);
                });

                // Cập nhật icon
                function updateIcon(theme) {
                    icon.className = theme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
