@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Dashboard</li>
    @endsection
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center py-5">
                    <i class="bi bi-person-check display-1 text-success mb-4"></i>
                    <h4 class="mb-3">Welcome to Dr. CRUD Pharmacy!</h4>
                    <p class="text-muted mb-4">You're successfully logged in. You should be automatically redirected to your role-specific dashboard.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh Dashboard
                        </a>
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
