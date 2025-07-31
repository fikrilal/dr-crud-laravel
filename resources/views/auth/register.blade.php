@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="text-center mb-4">
    <h4 class="mb-2">Create Account</h4>
    <p class="text-muted">Register as a customer to start shopping</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" 
               required autofocus autocomplete="name" placeholder="Enter your full name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" 
               required autocomplete="username" placeholder="Enter your email">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" 
               required autocomplete="new-password" placeholder="Enter your password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
               id="password_confirmation" name="password_confirmation" 
               required autocomplete="new-password" placeholder="Confirm your password">
        @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100">Create Account</button>
    </div>

    <div class="text-center">
        <p class="text-muted">Already have an account? 
            <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
        </p>
    </div>
</form>
@endsection
