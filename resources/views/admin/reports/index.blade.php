@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Reports & Analytics</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header with Date Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="card-title mb-2">
                                <i class="bi bi-graph-up me-2"></i>Reports & Analytics Dashboard
                            </h4>
                            <p class="card-text mb-0">Comprehensive analytics and insights for your pharmacy business.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <form method="GET" class="d-inline">
                                <select name="date_range" class="form-select form-select-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                    <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                                    <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                                    <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 3 Months</option>
                                    <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>Last Year</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="bi bi-capsule fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title">{{ number_format($overview['total_drugs']) }}</h3>
                    <p class="card-text text-muted">Total Drugs</p>
                    <small class="text-success">{{ $overview['active_drugs'] }} Active</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="bi bi-cart-check fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title">{{ number_format($overview['total_sales']) }}</h3>
                    <p class="card-text text-muted">Total Sales</p>
                    <small class="text-info">All Time</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-info">
                            <i class="bi bi-people fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title">{{ number_format($overview['total_customers']) }}</h3>
                    <p class="card-text text-muted">Total Customers</p>
                    <small class="text-primary">Registered Users</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="bi bi-exclamation-triangle fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title">{{ number_format($overview['low_stock_drugs']) }}</h3>
                    <p class="card-text text-muted">Low Stock Alerts</p>
                    <small class="text-warning">Needs Attention</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales & Financial Analytics -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Sales Performance
                    </h5>
                    <span class="badge bg-primary">Last {{ $dateRange }} Days</span>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-3">
                            <h4 class="text-primary">{{ number_format($salesAnalytics['total_sales']) }}</h4>
                            <small class="text-muted">Total Sales</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success">Rp {{ number_format($salesAnalytics['total_revenue'], 0, ',', '.') }}</h4>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info">{{ number_format($salesAnalytics['online_sales']) }}</h4>
                            <small class="text-muted">Online Orders</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning">Rp {{ number_format($salesAnalytics['average_order_value'], 0, ',', '.') }}</h4>
                            <small class="text-muted">Avg Order Value</small>
                        </div>
                    </div>
                    
                    <!-- Daily Sales Chart Placeholder -->
                    <div class="border rounded p-3 bg-light">
                        <h6 class="text-center text-muted mb-3">Daily Sales Trend</h6>
                        <div class="row">
                            @foreach($salesAnalytics['daily_sales']->take(7) as $day)
                            <div class="col text-center">
                                <div class="bg-primary rounded" style="height: {{ ($day->count / $salesAnalytics['daily_sales']->max('count')) * 100 }}px; min-height: 20px; margin-bottom: 5px;"></div>
                                <small class="text-muted">{{ Carbon\Carbon::parse($day->date)->format('M d') }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-trophy me-2"></i>Top Selling Drugs
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($salesAnalytics['top_drugs']->take(5) as $index => $drug)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $drug->nm_obat }}</h6>
                                <small class="text-muted">{{ $drug->total_quantity }} units sold</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary">{{ $index + 1 }}</span>
                                <br><small class="text-success">Rp {{ number_format($drug->total_revenue, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Analytics -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-bag-check me-2"></i>Order Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <h4 class="text-warning">{{ $orderAnalytics['pending_orders'] }}</h4>
                            <small class="text-muted">Pending</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $orderAnalytics['completed_orders'] }}</h4>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" style="width: {{ $orderAnalytics['completion_rate'] }}%"></div>
                    </div>
                    <div class="text-center">
                        <small class="text-muted">{{ number_format($orderAnalytics['completion_rate'], 1) }}% Completion Rate</small>
                    </div>
                    
                    <hr>
                    
                    <h6>Payment Methods</h6>
                    @foreach($orderAnalytics['payment_methods'] as $method)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-capitalize">{{ $method->payment_method ?: 'Not Specified' }}</span>
                        <div>
                            <span class="badge bg-primary me-2">{{ $method->count }}</span>
                            <small class="text-muted">Rp {{ number_format($method->total_amount, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>User Analytics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <h5 class="text-danger">{{ $userAnalytics['admin_count'] }}</h5>
                            <small class="text-muted">Admins</small>
                        </div>
                        <div class="col-4">
                            <h5 class="text-success">{{ $userAnalytics['pharmacist_count'] }}</h5>
                            <small class="text-muted">Pharmacists</small>
                        </div>
                        <div class="col-4">
                            <h5 class="text-info">{{ $userAnalytics['customer_count'] }}</h5>
                            <small class="text-muted">Customers</small>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-person-plus me-2"></i>
                        <strong>{{ $userAnalytics['new_registrations'] }}</strong> new registrations in the last {{ $dateRange }} days
                    </div>
                    
                    <h6>Most Active Customers</h6>
                    @foreach($userAnalytics['active_customers']->take(3) as $customer)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">{{ $customer->name }}</h6>
                            <small class="text-muted">{{ $customer->email }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary">{{ $customer->order_count }} orders</span>
                            <br><small class="text-success">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Analytics -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-boxes me-2"></i>Inventory Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-4">
                            <h4 class="text-success">{{ $inventoryAnalytics['active_drugs'] }}</h4>
                            <small class="text-muted">Active Drugs</small>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-warning">{{ $inventoryAnalytics['low_stock_count'] }}</h4>
                            <small class="text-muted">Low Stock</small>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-danger">{{ $inventoryAnalytics['out_of_stock_count'] }}</h4>
                            <small class="text-muted">Out of Stock</small>
                        </div>
                    </div>
                    
                    <div class="alert alert-success">
                        <i class="bi bi-currency-dollar me-2"></i>
                        Total Inventory Value: <strong>Rp {{ number_format($inventoryAnalytics['total_inventory_value'], 0, ',', '.') }}</strong>
                    </div>
                    
                    @if($inventoryAnalytics['low_stock_drugs']->count() > 0)
                    <div class="alert alert-warning">
                        <h6><i class="bi bi-exclamation-triangle me-2"></i>Low Stock Alerts</h6>
                        @foreach($inventoryAnalytics['low_stock_drugs']->take(3) as $drug)
                        <div class="d-flex justify-content-between">
                            <span>{{ $drug->nm_obat }}</span>
                            <span class="badge bg-warning">{{ $drug->stok }} units left</span>
                        </div>
                        @endforeach
                        @if($inventoryAnalytics['low_stock_drugs']->count() > 3)
                        <small class="text-muted">And {{ $inventoryAnalytics['low_stock_drugs']->count() - 3 }} more...</small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-award me-2"></i>Performance Metrics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Financial Performance</h6>
                        <div class="d-flex justify-content-between">
                            <span>Total Revenue</span>
                            <strong class="text-success">Rp {{ number_format($financialAnalytics['total_revenue'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Gross Profit</span>
                            <strong class="text-primary">Rp {{ number_format($financialAnalytics['gross_profit'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Profit Margin</span>
                            <strong class="text-info">{{ number_format($financialAnalytics['profit_margin'], 1) }}%</strong>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <h6>Top Performing Staff</h6>
                        @foreach($performanceAnalytics['top_pharmacists']->take(3) as $pharmacist)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $pharmacist->name }}</span>
                            <div class="text-end">
                                <span class="badge bg-success">{{ $pharmacist->sales_count }}</span>
                                <br><small class="text-muted">Rp {{ number_format($pharmacist->total_revenue, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        @endforeach
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
                    <h5 class="mb-0">
                        <i class="bi bi-download me-2"></i>Export Reports
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary w-100 mb-2" onclick="exportReport('sales', 'csv')">
                                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Sales Report (CSV)
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-success w-100 mb-2" onclick="exportReport('inventory', 'pdf')">
                                <i class="bi bi-file-earmark-pdf me-2"></i>Inventory Report (PDF)
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-info w-100 mb-2" onclick="exportReport('customers', 'csv')">
                                <i class="bi bi-people me-2"></i>Customer Report (CSV)
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-warning w-100 mb-2" onclick="exportReport('financial', 'pdf')">
                                <i class="bi bi-currency-dollar me-2"></i>Financial Report (PDF)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportReport(type, format) {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Exporting...';
    button.disabled = true;
    
    fetch(`{{ route('admin.reports.export') }}?type=${type}&format=${format}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Export feature would download the file here');
        } else {
            alert('Export failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during export');
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Auto-refresh data every 5 minutes
setInterval(function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 300000);
</script>
@endpush