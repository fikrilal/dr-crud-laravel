@extends('layouts.app')

@section('title', 'Pharmacist Dashboard')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Pharmacist Dashboard</li>
    @endsection
@endsection

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-2">Good day, {{ Auth::user()->name }}!</h4>
                        <p class="card-text mb-0">Ready to serve customers and manage pharmacy operations.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div id="dashboard-clock" class="h5 mb-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Today's Sales</h6>
                        <h2 class="mb-0">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-arrow-up"></i> {{ $stats['today_sales'] }} transactions
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-cart-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">This Week</h6>
                        <h2 class="mb-0">Rp {{ number_format($stats['week_revenue'], 0, ',', '.') }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-check-circle"></i> {{ $stats['week_sales'] }} sales
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-calendar-week fs-1"></i>
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
                        <h6 class="card-title text-white-50">Low Stock</h6>
                        <h2 class="mb-0">{{ $stats['low_stock_count'] }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-exclamation-triangle"></i> 
                            @if($stats['low_stock_count'] > 0)
                                Need reorder
                            @else
                                All stocked
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
                        <h6 class="card-title text-white-50">Pending Orders</h6>
                        <h2 class="mb-0">{{ $stats['pending_orders'] }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-clock"></i> 
                            @if($stats['pending_orders'] > 0)
                                Need processing
                            @else
                                All processed
                            @endif
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-hourglass fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Operations -->
<div class="row mb-4">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Operations</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" data-bs-toggle="modal" data-bs-target="#newSaleModal">
                            <i class="bi bi-plus-circle fs-2 mb-2"></i>
                            <span>New Sale</span>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('drugs.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-search fs-2 mb-2"></i>
                            <span>Search Drugs</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" data-bs-toggle="modal" data-bs-target="#addStockModal">
                            <i class="bi bi-box-seam fs-2 mb-2"></i>
                            <span>Add Stock</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Search</h5>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Drug name or code..." id="quickSearch">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-upc-scan me-2"></i>Scan Barcode
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sales & Alerts -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Sales</h5>
                <a href="{{ route('sales.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                @if($stats['recent_sales']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Receipt #</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_sales']->take(5) as $sale)
                                <tr>
                                    <td><span class="badge bg-primary">#{{ $sale->nota }}</span></td>
                                    <td>
                                        @if($sale->tipe_transaksi == 'online')
                                            <span class="badge bg-info">Online</span>
                                        @else
                                            <span class="badge bg-secondary">Direct</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($sale->total_after_discount, 0, ',', '.') }}</td>
                                    <td><small class="text-muted">{{ $sale->created_at->diffForHumans() }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-cart-x display-4 text-muted mb-2"></i>
                        <p class="text-muted">No recent sales</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Inventory Alerts</h5>
                <a href="{{ route('expiry-alerts.index') }}" class="btn btn-outline-warning btn-sm">View All</a>
            </div>
            <div class="card-body">
                @if($stats['low_stock_count'] > 0 || $stats['out_of_stock_count'] > 0)
                    <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <div>
                            @if($stats['out_of_stock_count'] > 0)
                                <strong>{{ $stats['out_of_stock_count'] }}</strong> items are out of stock,
                            @endif
                            @if($stats['low_stock_count'] > 0)
                                <strong>{{ $stats['low_stock_count'] }}</strong> items are running low
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <div>All inventory levels are good!</div>
                    </div>
                @endif
                
                @if($stats['low_stock_drugs']->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($stats['low_stock_drugs']->take(3) as $drug)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <h6 class="mb-1">{{ $drug->nm_obat }}</h6>
                                <small class="text-muted">Current stock: {{ $drug->stok }} units</small>
                            </div>
                            @if($drug->stok <= 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($drug->stok <= 5)
                                <span class="badge bg-danger">Critical</span>
                            @else
                                <span class="badge bg-warning">Low</span>
                            @endif
                        </div>
                        @endforeach
                        
                        @if($stats['low_stock_drugs']->count() > 3)
                        <div class="list-group-item text-center px-0">
                            <small class="text-muted">
                                And {{ $stats['low_stock_drugs']->count() - 3 }} more items...
                                <a href="{{ route('drugs.index') }}?filter=low_stock" class="ms-2">View all</a>
                            </small>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation Cards -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Main Operations</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('drugs.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-capsule fs-1 mb-3"></i>
                            <span class="h6">Drug Inventory</span>
                            <small class="text-muted">Manage drug stock and information</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('sales.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-cart-check fs-1 mb-3"></i>
                            <span class="h6">Sales Management</span>
                            <small class="text-muted">Process sales and view history</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('purchases.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-bag fs-1 mb-3"></i>
                            <span class="h6">Purchase Orders</span>
                            <small class="text-muted">Manage supplier orders</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-laptop fs-1 mb-3"></i>
                            <span class="h6">Online Orders</span>
                            <small class="text-muted">Process customer orders</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 