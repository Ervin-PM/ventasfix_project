<!DOCTYPE html>
<html lang="es" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('template/assets/') }}" data-template="vertical-menu-template-no-customizer">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VentasFix Backoffice')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    @php
        $coreCss = public_path('template/assets/vendor/css/rtl/core.css');
    @endphp
    <!DOCTYPE html>
    <html lang="es" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('template/assets/') }}" data-template="vertical-menu-template-no-customizer">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title', 'VentasFix Backoffice')</title>

            <!-- Fonts & Icons -->
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

            @php $coreCss = public_path('template/assets/vendor/css/rtl/core.css'); @endphp
            @if(file_exists($coreCss))
                <link rel="icon" type="image/x-icon" href="{{ asset('template/assets/img/favicon/favicon.ico') }}" />
                <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/fontawesome.css') }}" />
                <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/tabler-icons.css') }}" />
                <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/flag-icons.css') }}" />
                <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/rtl/core.css') }}" />
                <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/rtl/theme-default.css') }}" />
                <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
            @else
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            @endif

            @stack('head')
        </head>

        <body>
            <div class="layout-wrapper layout-content-navbar">
                <div class="layout-container">
                    <!-- Sidebar -->
                    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                            <div class="app-brand demo">
                            <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/dashboard') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <!-- small logo SVG kept from template -->
                                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 0 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0"/></svg>
                                </span>
                                <span class="app-brand-text demo menu-text fw-bold">VentasFix</span>
                            </a>
                            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                                <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
                            </a>
                        </div>

                        <div class="menu-inner-shadow"></div>

                                    <ul class="menu-inner py-1">
                                        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active open' : '' }}">
                                            <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/dashboard') }}" class="menu-link">
                                                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                                                <div>Dashboard</div>
                                            </a>
                                        </li>
                                        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                            <a href="{{ Route::has('users.index') ? route('users.index') : url('/users') }}" class="menu-link">
                                                <i class="menu-icon tf-icons ti ti-users"></i>
                                                <div>Usuarios</div>
                                            </a>
                                        </li>
                                        <li class="menu-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                            <a href="{{ Route::has('products.index') ? route('products.index') : url('/products') }}" class="menu-link">
                                                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                                                <div>Productos</div>
                                            </a>
                                        </li>
                                        <li class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                                            <a href="{{ Route::has('clients.index') ? route('clients.index') : url('/clients') }}" class="menu-link">
                                                <i class="menu-icon tf-icons ti ti-building"></i>
                                                <div>Clientes</div>
                                            </a>
                                        </li>
                                    </ul>
                    </aside>

                    <!-- Content wrapper -->
                    <div class="layout-page">
                        <!-- Navbar -->
                        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                            <div class="layout-menu-toggle navbar-nav d-xl-none">
                                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0);">
                                    <i class="ti ti-menu-2 ti-sm"></i>
                                </a>
                            </div>

                            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                                <ul class="navbar-nav ms-auto">
                                    @auth
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ auth()->user()->nombre ?? auth()->user()->email }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                                            <li>
                                                @php
                                                    // Use named route if available, otherwise fallback to a URL path to avoid RouteNotFoundException
                                                    $logoutAction = \Illuminate\Support\Facades\Route::has('logout') ? route('logout') : url('/logout');
                                                @endphp
                                                <form method="POST" action="{{ $logoutAction }}">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit" title="Cerrar sesión">Cerrar sesión</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    @endauth
                                </ul>
                            </div>
                        </nav>

                        <!-- Main content -->
                        <div class="content-wrapper">
                            <div class="container flex-grow-1 container-p-y my-4">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @yield('content')
                            </div>
                        </div>

                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl d-flex justify-content-between py-2">
                                <div>© {{ date('Y') }} VentasFix</div>
                                <div>Hecho con <strong>Vuexy</strong></div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>

            @php $mainJs = public_path('template/assets/js/main.js'); @endphp
            @if(file_exists($mainJs))
                <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
                <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
                <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
                <script src="{{ asset('template/assets/js/config.js') }}"></script>
                <script src="{{ asset('template/assets/js/main.js') }}"></script>
            @else
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            @endif

            @stack('scripts')
        </body>
    </html>