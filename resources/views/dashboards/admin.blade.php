@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Admin Dashboard</li>
    @endsection
@endsection

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-2">Welcome back, {{ Auth::user()->name }}!</h4>
                        <p class="card-text mb-0">Here's what's happening in your pharmacy today.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div id="dashboard-clock" class="h5 mb-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-gradient text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Total Users</h6>
                        <h2 class="mb-0">1,247</h2>
                        <small class="text-white-50">
                            <i class="bi bi-arrow-up"></i> +12% from last month
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Total Revenue</h6>
                        <h2 class="mb-0">$45,670</h2>
                        <small class="text-white-50">
                            <i class="bi bi-arrow-up"></i> +8% from last month
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Low Stock Items</h6>
                        <h2 class="mb-0">23</h2>
                        <small class="text-white-50">
                            <i class="bi bi-exclamation-triangle"></i> Needs attention
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-box fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Expiring Soon</h6>
                        <h2 class="mb-0">8</h2>
                        <small class="text-white-50">
                            <i class="bi bi-calendar-x"></i> Within 30 days
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-exclamation-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-people fs-2 mb-2"></i>
                            <span>Manage Users</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-truck fs-2 mb-2"></i>
                            <span>Manage Suppliers</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-bar-chart fs-2 mb-2"></i>
                            <span>View Reports</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-gear fs-2 mb-2"></i>
                            <span>System Settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some animation to the stats cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in');
        }, index * 100);
    });
 