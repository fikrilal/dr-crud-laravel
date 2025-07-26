<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dr. CRUD') }} - @yield('title', 'Authentication')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary">
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-4">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <a href="{{ route('welcome') ?? '/' }}" class="text-decoration-none">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-heart-pulse text-primary fs-1"></i>
                            </div>
                            <h2 class="text-white fw-bold mb-1">{{ config('app.name', 'Dr. CRUD') }}</h2>
                            <p class="text-white-50 mb-0">Pharmacy Management System</p>
                        </a>
                    </div>

                    <!-- Auth Card -->
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4">
                            @yield('content')
                        </div>
                    </div>

                    <!-- Footer Links -->
                    <div class="text-center mt-4">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('welcome') ?? '/' }}" class="text-white-50 text-decoration-none small">
                                    <i class="bi bi-arrow-left me-1"></i>Back to Home
                                </a>
                            </div>
                            <div class="col-6 text-end">
                                <a href="#" class="text-white-50 text-decoration-none small">
                                    Need Help? <i class="bi bi-question-circle ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-white-50">
                                &copy; {{ date('Y') }} Dr. CRUD Pharmacy Management System
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
