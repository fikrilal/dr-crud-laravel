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
                        <h2 class="mb-0">{{ number_format($stats['total_users']) }}</h2>
                        <small class="text-white-50">
                            @if($stats['user_growth'] >= 0)
                                <i class="bi bi-arrow-up"></i> +{{ number_format($stats['user_growth'], 1) }}% from last month
                            @else
                                <i class="bi bi-arrow-down"></i> {{ number_format($stats['user_growth'], 1) }}% from last month
                            @endif
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
                        <h2 class="mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h2>
                        <small class="text-white-50">
                            @if($stats['revenue_growth'] >= 0)
                                <i class="bi bi-arrow-up"></i> +{{ number_format($stats['revenue_growth'], 1) }}% from last month
                            @else
                                <i class="bi bi-arrow-down"></i> {{ number_format($stats['revenue_growth'], 1) }}% from last month
                            @endif
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
                        <h2 class="mb-0">{{ $stats['low_stock_items'] }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-exclamation-triangle"></i> 
                            @if($stats['low_stock_items'] > 0)
                                Needs attention
                            @else
                                All good
                            @endif
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
                        <h2 class="mb-0">{{ $stats['expiring_soon'] }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-calendar-x"></i> 
                            @if($stats['expiring_soon'] > 0)
                                Within 30 days
                            @else
                                All fresh
                            @endif
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

<!-- Real-time Activity Dashboard -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Today's Overview</h5>
                <small class="text-muted">{{ Carbon\Carbon::now()->format('F d, Y') }}</small>
            </div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col-md-3">
                        <h4 class="text-primary">{{ $stats['today_sales'] }}</h4>
                        <small class="text-muted">Sales Today</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-success">{{ $stats['pending_orders'] }}</h4>
                        <small class="text-muted">Pending Orders</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-info">{{ $stats['total_drugs'] }}</h4>
                        <small class="text-muted">Active Drugs</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning">{{ $stats['total_suppliers'] }}</h4>
                        <small class="text-muted">Suppliers</small>
                    </div>
                </div>
                
                @if($stats['pending_orders'] > 0 || $stats['low_stock_items'] > 0 || $stats['expiring_soon'] > 0)
                <div class="alert alert-warning">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Attention Required</h6>
                    <ul class="mb-0">
                        @if($stats['pending_orders'] > 0)
                            <li><strong>{{ $stats['pending_orders'] }}</strong> pending orders need processing</li>
                        @endif
                        @if($stats['low_stock_items'] > 0)
                            <li><strong>{{ $stats['low_stock_items'] }}</strong> items are running low on stock</li>
                        @endif
                        @if($stats['expiring_soon'] > 0)
                            <li><strong>{{ $stats['expiring_soon'] }}</strong> drugs are expiring soon</li>
                        @endif
                    </ul>
                </div>
                @else
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>All systems are running smoothly!
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($stats['recent_sales']->take(5) as $sale)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">Sale #{{ $sale->nota }}</h6>
                                <small class="text-muted">
                                    @if($sale->user)
                                        by {{ $sale->user->name }}
                                    @else
                                        Direct sale
                                    @endif
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">Rp {{ number_format($sale->total_after_discount, 0, ',', '.') }}</span>
                                <br><small class="text-muted">{{ $sale->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        No recent sales
                    </div>
                    @endforelse
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
                            <small class="text-muted">{{ $stats['total_users'] }} total users</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-truck fs-2 mb-2"></i>
                            <span>Manage Suppliers</span>
                            <small class="text-muted">{{ $stats['total_suppliers'] }} suppliers</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-bar-chart fs-2 mb-2"></i>
                            <span>View Reports</span>
                            <small class="text-muted">Analytics & insights</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('expiry-alerts.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-exclamation-triangle fs-2 mb-2"></i>
                            <span>Expiry Alerts</span>
                            @if($stats['expiring_soon'] > 0)
                                <small class="text-danger">{{ $stats['expiring_soon'] }} expiring</small>
                            @else
                                <small class="text-success">All fresh</small>
                            @endif
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
 