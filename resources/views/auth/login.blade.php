@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="text-center mb-4">
    <h4 class="fw-bold mb-1">Welcome Back!</h4>
    <p class="text-muted mb-0">Sign in to your account to continue</p>
</div>

<!-- Session Status -->
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-envelope"></i>
            </span>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter your email address"
            >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-lock"></i>
            </span>
            <input 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                id="password" 
                name="password" 
                required 
                autocomplete="current-password"
                placeholder="Enter your password"
            >
            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- Remember Me -->
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Remember me for 30 days
            </label>
        </div>
    </div>

    <!-- Login Button -->
    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-2"></i>
            Sign In
        </button>
    </div>

    <!-- Forgot Password -->
    <div class="text-center mb-3">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-decoration-none">
                <i class="bi bi-question-circle me-1"></i>
                Forgot your password?
            </a>
        @endif
    </div>

    <!-- Divider -->
    <hr class="my-4">

    <!-- Demo Accounts -->
    <div class="text-center">
        <p class="text-muted small mb-2">Demo Accounts:</p>
        <div class="row g-2">
            <div class="col-4">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="fillDemo('admin@pharmacy.com', 'admin123')">
                    <i class="bi bi-person-gear"></i><br>
                    <small>Admin</small>
                </button>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-outline-success btn-sm w-100" onclick="fillDemo('pharmacist@pharmacy.com', 'pharma123')">
                    <i class="bi bi-person-hearts"></i><br>
                    <small>Pharmacist</small>
                </button>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-outline-info btn-sm w-100" onclick="fillDemo('customer@pharmacy.com', 'customer123')">
                    <i class="bi bi-person"></i><br>
                    <small>Customer</small>
                </button>
            </div>
        </div>
    </div>

    <!-- Register Link -->
    <div class="text-center mt-4">
        <p class="text-muted mb-0">
            Don't have an account? 
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                    Create Account
                </a>
            @endif
        </p>
    </div>
</form>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'bi bi-eye-slash';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'bi bi-eye';
    }
}

function fillDemo(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
@endsection
