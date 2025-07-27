<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dr. CRUD') }} - @yield('title', 'Pharmacy Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
    
    <style>
        /* Modern Navigation Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        .modern-navbar {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            backdrop-filter: blur(20px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            color: #f8fafc !important;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .navbar-brand:hover {
            color: #3b82f6 !important;
        }
        
        .navbar-brand i {
            margin-right: 0.75rem;
            color: #3b82f6;
        }
        
        .navbar-end {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            color: #94a3b8 !important;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link:hover {
            color: #f8fafc !important;
            background: rgba(59, 130, 246, 0.1);
        }
        
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .dropdown-menu {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 280px;
        }
        
        .dropdown-item {
            color: #e2e8f0 !important;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .dropdown-item:hover {
            background: #334155 !important;
            color: #f8fafc !important;
        }
        
        .dropdown-header {
            color: #f8fafc;
            font-weight: 600;
            padding: 0.75rem 1rem 0.5rem;
            border-bottom: 1px solid #334155;
            margin-bottom: 0.5rem;
        }
        
        .dropdown-divider {
            border-top: 1px solid #334155;
            margin: 0.5rem 0;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 2px solid #334155;
        }
        
        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            width: 280px;
            height: calc(100vh - 64px);
            background: #1e293b;
            border-right: 1px solid #334155;
            overflow-y: auto;
            z-index: 900;
            transition: transform 0.3s ease;
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .main-content {
            margin-left: 280px;
            margin-top: 64px;
            min-height: calc(100vh - 64px);
            background: #0f172a;
            transition: margin-left 0.3s ease;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-toggle:hover {
            color: #f8fafc;
            background: rgba(59, 130, 246, 0.1);
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 850;
            display: none;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .navbar-end .user-name {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Modern Navigation -->
        <nav class="modern-navbar">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-heart-pulse"></i>
                {{ config('app.name', 'Dr. CRUD') }}
            </a>
            
            <div class="navbar-end">
                <!-- Mobile menu toggle -->
                <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                
                <!-- Notifications -->
                <div class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                            <div>
                                <div class="fw-medium">Low Stock Alert</div>
                                <small class="text-muted">5 drugs running low</small>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="bi bi-clock text-info"></i>
                            <div>
                                <div class="fw-medium">Expiry Warning</div>
                                <small class="text-muted">3 items expiring soon</small>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <div class="fw-medium">Order Completed</div>
                                <small class="text-muted">Order #ORD-2024-001</small>
                            </div>
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center fw-medium" href="#">View All Notifications</a></li>
                    </ul>
                </div>

                <!-- User menu -->
                <div class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=ffffff" 
                             alt="Avatar" class="user-avatar">
                        <span class="user-name d-none d-md-inline">{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                        <li><small class="dropdown-item-text text-muted px-3">{{ ucfirst(Auth::user()->user_type) }}</small></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i>
                            Profile Settings
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i>
                            Preferences
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item w-100 text-start">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar overlay for mobile -->
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            @include('layouts.navigation')
        </aside>

        <!-- Main content -->
        <main class="main-content" id="mainContent">
            <div class="p-4">
                <!-- Page Header -->
                @hasSection('header')
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-white">@yield('title', 'Dashboard')</h1>
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
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #10b981;">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) saturate(100%) invert(48%) sepia(70%) saturate(4086%) hue-rotate(130deg) brightness(119%) contrast(119%);"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171;">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) saturate(100%) invert(48%) sepia(70%) saturate(4086%) hue-rotate(340deg) brightness(119%) contrast(119%);"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background: rgba(251, 146, 60, 0.1); border: 1px solid rgba(251, 146, 60, 0.2); color: #fbbf24;">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) saturate(100%) invert(48%) sepia(70%) saturate(4086%) hue-rotate(30deg) brightness(119%) contrast(119%);"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                        <i class="bi bi-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) saturate(100%) invert(48%) sepia(70%) saturate(4086%) hue-rotate(200deg) brightness(119%) contrast(119%);"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer style="background: #1e293b; border-top: 1px solid #334155; margin-top: auto; padding: 1.5rem 0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} Dr. CRUD Pharmacy Management System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">Built with Laravel {{ Illuminate\Foundation\Application::VERSION }}</small>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    toggleSidebar();
                });
            }

            // Auto-close sidebar on mobile when window is resized to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.querySelector('.sidebar-overlay');
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
