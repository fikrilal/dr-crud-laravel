@extends('layouts.app')

@section('title', 'Reports & Analytics')

@push('styles')
<style>
/* Modern Reports & Analytics Page Styles */
.modern-reports-header {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #e2e8f0;
}

.modern-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    margin-bottom: 1.5rem;
}

.modern-card-header {
    background: #0f172a;
    border-bottom: 1px solid #334155;
    padding: 1.5rem;
    color: #f8fafc;
    border-radius: 16px 16px 0 0;
}

.modern-card-body {
    padding: 1.5rem;
    color: #e2e8f0;
}

.modern-form-control {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
}

.modern-form-control:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    outline: none !important;
}

.modern-form-control::placeholder {
    color: #94a3b8 !important;
}

.modern-form-control option {
    background: #334155 !important;
    color: #e2e8f0 !important;
    border: none !important;
}

.form-select.modern-form-control {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
    padding-right: 2.25rem !important;
    border-radius: 8px;
}

.modern-form-control.form-select-sm {
    padding: 0.375rem 2rem 0.375rem 0.75rem !important;
    font-size: 0.875rem !important;
}

.stats-card {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    color: #e2e8f0;
    transition: all 0.2s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.stats-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.stats-avatar.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stats-avatar.bg-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stats-avatar.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
}

.stats-avatar.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
}

.stats-value {
    font-size: 2rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #cbd5e1;
    font-size: 0.875rem;
    font-weight: 500;
}

.metrics-card {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    color: #e2e8f0;
}

.metrics-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 0.25rem;
}

.metrics-subtitle {
    color: #94a3b8;
    font-size: 0.875rem;
    margin-bottom: 0;
}

.modern-badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
}

.modern-badge.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    color: white !important;
}

.modern-badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white !important;
}

.modern-badge.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    color: white !important;
}

.modern-badge.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    color: white !important;
}

.chart-container {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
}

.chart-placeholder {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    color: #94a3b8;
}

.list-group-item {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    color: #e2e8f0 !important;
}

.list-group-item:hover {
    background: #334155 !important;
}

.alert-modern {
    border: 1px solid #334155;
    border-radius: 8px;
    color: #e2e8f0;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
}

.alert-modern.alert-info {
    background: rgba(6, 182, 212, 0.1);
    border-color: #0891b2;
}

.alert-modern.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border-color: #059669;
}

.alert-modern.alert-warning {
    background: rgba(251, 191, 36, 0.1);
    border-color: #f59e0b;
}

.progress {
    background: #334155 !important;
    border-radius: 8px;
    height: 12px;
}

.progress-bar {
    border-radius: 8px;
}

.progress-bar.bg-success {
    background: linear-gradient(90deg, #10b981, #059669) !important;
}

.text-primary {
    color: #3b82f6 !important;
}

.text-success {
    color: #10b981 !important;
}

.text-info {
    color: #06b6d4 !important;
}

.text-warning {
    color: #fbbf24 !important;
}

.text-danger {
    color: #ef4444 !important;
}

.text-muted {
    color: #94a3b8 !important;
}

.bg-light {
    background: #0f172a !important;
    border: 1px solid #334155 !important;
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header Section -->
    <div class="modern-reports-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Reports & Analytics Dashboard</h2>
                    <p class="mb-0" style="color: #94a3b8;">Comprehensive analytics and insights for your pharmacy business</p>
                </div>
            </div>
            <div>
                <form method="GET" class="d-inline">
                    <select name="date_range" class="form-select modern-form-control form-select-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                        <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>Last Year</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Modern Overview Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-primary">
                    <i class="bi bi-capsule"></i>
                </div>
                <div class="stats-value">{{ number_format($overview['total_drugs']) }}</div>
                <div class="stats-label">Total Drugs</div>
                <small class="text-success mt-2 d-block">{{ $overview['active_drugs'] }} Active</small>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-success">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div class="stats-value">{{ number_format($overview['total_sales']) }}</div>
                <div class="stats-label">Total Sales</div>
                <small class="text-info mt-2 d-block">All Time</small>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-info">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-value">{{ number_format($overview['total_customers']) }}</div>
                <div class="stats-label">Total Customers</div>
                <small class="text-primary mt-2 d-block">Registered Users</small>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stats-value">{{ number_format($overview['low_stock_drugs']) }}</div>
                <div class="stats-label">Low Stock Alerts</div>
                <small class="text-warning mt-2 d-block">Needs Attention</small>
            </div>
        </div>
    </div>

    <!-- Modern Sales & Financial Analytics -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="modern-card h-100">
                <div class="modern-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Sales Performance
                    </h5>
                    <span class="modern-badge bg-primary">Last {{ $dateRange }} Days</span>
                </div>
                <div class="modern-card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-3">
                            <div class="metrics-card">
                                <div class="metrics-title text-primary">{{ number_format($salesAnalytics['total_sales']) }}</div>
                                <div class="metrics-subtitle">Total Sales</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metrics-card">
                                <div class="metrics-title text-success">Rp {{ number_format($salesAnalytics['total_revenue'], 0, ',', '.') }}</div>
                                <div class="metrics-subtitle">Total Revenue</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metrics-card">
                                <div class="metrics-title text-info">{{ number_format($salesAnalytics['online_sales']) }}</div>
                                <div class="metrics-subtitle">Online Orders</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metrics-card">
                                <div class="metrics-title text-warning">Rp {{ number_format($salesAnalytics['average_order_value'], 0, ',', '.') }}</div>
                                <div class="metrics-subtitle">Avg Order Value</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Daily Sales Chart Placeholder -->
                    <div class="chart-placeholder">
                        <h6 class="text-center mb-3" style="color: #f8fafc;">Daily Sales Trend</h6>
                        <div class="row">
                            @foreach($salesAnalytics['daily_sales']->take(7) as $day)
                            <div class="col text-center">
                                <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 4px; height: {{ ($day->count / $salesAnalytics['daily_sales']->max('count')) * 100 }}px; min-height: 20px; margin-bottom: 5px;"></div>
                                <small style="color: #94a3b8;">{{ Carbon\Carbon::parse($day->date)->format('M d') }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="modern-card h-100">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-trophy me-2"></i>Top Selling Drugs
                    </h5>
                </div>
                <div class="p-0">
                    <div class="list-group list-group-flush">
                        @foreach($salesAnalytics['top_drugs']->take(5) as $index => $drug)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1" style="color: #f8fafc;">{{ $drug->nm_obat }}</h6>
                                <small style="color: #94a3b8;">{{ $drug->total_quantity }} units sold</small>
                            </div>
                            <div class="text-end">
                                <span class="modern-badge bg-primary">{{ $index + 1 }}</span>
                                <br><small class="text-success">Rp {{ number_format($drug->total_revenue, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Order Analytics -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-bag-check me-2"></i>Order Management
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="metrics-card">
                                <div class="metrics-title text-warning">{{ $orderAnalytics['pending_orders'] }}</div>
                                <div class="metrics-subtitle">Pending</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metrics-card">
                                <div class="metrics-title text-success">{{ $orderAnalytics['completed_orders'] }}</div>
                                <div class="metrics-subtitle">Completed</div>
                            </div>
                        </div>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" style="width: {{ $orderAnalytics['completion_rate'] }}%"></div>
                    </div>
                    <div class="text-center">
                        <small style="color: #94a3b8;">{{ number_format($orderAnalytics['completion_rate'], 1) }}% Completion Rate</small>
                    </div>
                    
                    <hr style="border-color: #334155;">
                    
                    <h6 style="color: #f8fafc;">Payment Methods</h6>
                    @foreach($orderAnalytics['payment_methods'] as $method)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-capitalize" style="color: #e2e8f0;">{{ $method->payment_method ?: 'Not Specified' }}</span>
                        <div>
                            <span class="modern-badge bg-primary me-2">{{ $method->count }}</span>
                            <small style="color: #94a3b8;">Rp {{ number_format($method->total_amount, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>User Analytics
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <div class="metrics-card">
                                <div class="metrics-title text-danger">{{ $userAnalytics['admin_count'] }}</div>
                                <div class="metrics-subtitle">Admins</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="metrics-card">
                                <div class="metrics-title text-success">{{ $userAnalytics['pharmacist_count'] }}</div>
                                <div class="metrics-subtitle">Pharmacists</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="metrics-card">
                                <div class="metrics-title text-info">{{ $userAnalytics['customer_count'] }}</div>
                                <div class="metrics-subtitle">Customers</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-modern alert-info">
                        <i class="bi bi-person-plus me-2"></i>
                        <strong>{{ $userAnalytics['new_registrations'] }}</strong> new registrations in the last {{ $dateRange }} days
                    </div>
                    
                    <h6 style="color: #f8fafc;">Most Active Customers</h6>
                    @foreach($userAnalytics['active_customers']->take(3) as $customer)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0" style="color: #f8fafc;">{{ $customer->name }}</h6>
                            <small style="color: #94a3b8;">{{ $customer->email }}</small>
                        </div>
                        <div class="text-end">
                            <span class="modern-badge bg-primary">{{ $customer->order_count }} orders</span>
                            <br><small class="text-success">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Inventory Analytics -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-boxes me-2"></i>Inventory Overview
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-4">
                            <div class="metrics-card">
                                <div class="metrics-title text-success">{{ $inventoryAnalytics['active_drugs'] }}</div>
                                <div class="metrics-subtitle">Active Drugs</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metrics-card">
                                <div class="metrics-title text-warning">{{ $inventoryAnalytics['low_stock_count'] }}</div>
                                <div class="metrics-subtitle">Low Stock</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metrics-card">
                                <div class="metrics-title text-danger">{{ $inventoryAnalytics['out_of_stock_count'] }}</div>
                                <div class="metrics-subtitle">Out of Stock</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-modern alert-success">
                        <i class="bi bi-currency-dollar me-2"></i>
                        Total Inventory Value: <strong>Rp {{ number_format($inventoryAnalytics['total_inventory_value'], 0, ',', '.') }}</strong>
                    </div>
                    
                    @if($inventoryAnalytics['low_stock_drugs']->count() > 0)
                    <div class="alert-modern alert-warning">
                        <h6 style="color: #f8fafc;"><i class="bi bi-exclamation-triangle me-2"></i>Low Stock Alerts</h6>
                        @foreach($inventoryAnalytics['low_stock_drugs']->take(3) as $drug)
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #e2e8f0;">{{ $drug->nm_obat }}</span>
                            <span class="modern-badge bg-warning">{{ $drug->stok }} units left</span>
                        </div>
                        @endforeach
                        @if($inventoryAnalytics['low_stock_drugs']->count() > 3)
                        <small style="color: #94a3b8;">And {{ $inventoryAnalytics['low_stock_drugs']->count() - 3 }} more...</small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-award me-2"></i>Performance Metrics
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="mb-3">
                        <h6 style="color: #f8fafc;">Financial Performance</h6>
                        <div class="metrics-card mb-2">
                            <div class="d-flex justify-content-between">
                                <span style="color: #94a3b8;">Total Revenue</span>
                                <strong class="text-success">Rp {{ number_format($financialAnalytics['total_revenue'], 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="metrics-card mb-2">
                            <div class="d-flex justify-content-between">
                                <span style="color: #94a3b8;">Gross Profit</span>
                                <strong class="text-primary">Rp {{ number_format($financialAnalytics['gross_profit'], 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="metrics-card mb-2">
                            <div class="d-flex justify-content-between">
                                <span style="color: #94a3b8;">Profit Margin</span>
                                <strong class="text-info">{{ number_format($financialAnalytics['profit_margin'], 1) }}%</strong>
                            </div>
                        </div>
                    </div>
                    
                    <hr style="border-color: #334155;">
                    
                    <div class="mb-3">
                        <h6 style="color: #f8fafc;">Top Performing Staff</h6>
                        @foreach($performanceAnalytics['top_pharmacists']->take(3) as $pharmacist)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #e2e8f0;">{{ $pharmacist->name }}</span>
                            <div class="text-end">
                                <span class="modern-badge bg-success">{{ $pharmacist->sales_count }}</span>
                                <br><small style="color: #94a3b8;">Rp {{ number_format($pharmacist->total_revenue, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Auto-refresh data every 5 minutes
setInterval(function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 300000);
</script>
@endpush