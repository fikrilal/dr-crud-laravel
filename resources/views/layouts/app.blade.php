<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dr. CRUD') }} - @yield('title', 'Pharmacy Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                    <i class="bi bi-heart-pulse me-2 fs-4"></i>
                    {{ config('app.name', 'Dr. CRUD') }}
                </a>

                <!-- Mobile menu button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Right side menu -->
                <div class="navbar-nav ms-auto">
                    <!-- Notifications -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-exclamation-triangle text-warning me-2"></i>5 drugs expiring soon</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box text-info me-2"></i>Low stock alert</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-check-circle text-success me-2"></i>Order completed</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                        </ul>
                    </div>

                    <!-- User menu -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=28a745&color=ffffff" 
                                 alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                            <li><small class="dropdown-item-text text-muted">{{ ucfirst(Auth::user()->user_type) }}</small></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid" style="padding-top: 80px;">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 px-0">
                    <div class="offcanvas-md offcanvas-start sidebar" tabindex="-1" id="sidebar">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title text-white">Menu</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
                        </div>
                        <div class="offcanvas-body p-0">
                            @include('layouts.navigation')
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="col-md-9 col-lg-10">
                    <main class="p-4">
                        <!-- Page Header -->
                        @hasSection('header')
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h1 class="h3 mb-0">@yield('title', 'Dashboard')</h1>
                                    @hasSection('breadcrumb')
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0">
                                                @yield('breadcrumb')
                                            </ol>
                                        </nav>
                                    @endif
                                </div>
                                @hasSection('header-actions')
                                    <div>
                                        @yield('header-actions')
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                {{ session('info') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Page Content -->
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 bg-dark text-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} Dr. CRUD Pharmacy Management System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">Built with Laravel {{ Illuminate\Foundation\Application::VERSION }}</small>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
