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
                        <h2 class="mb-0">$2,340</h2>
                        <small class="text-white-50">
                            <i class="bi bi-arrow-up"></i> 23 transactions
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
                        <h6 class="card-title text-white-50">Available Drugs</h6>
                        <h2 class="mb-0">1,456</h2>
                        <small class="text-white-50">
                            <i class="bi bi-check-circle"></i> In stock
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-capsule fs-1"></i>
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
                        <h2 class="mb-0">15</h2>
                        <small class="text-white-50">
                            <i class="bi bi-exclamation-triangle"></i> Need reorder
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
                        <h2 class="mb-0">5</h2>
                        <small class="text-white-50">
                            <i class="bi bi-calendar-x"></i> Next 7 days
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-clock fs-1"></i>
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
                        <a href="{{ route('pharmacist.drugs.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
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
                <a href="{{ route('pharmacist.sales.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Receipt #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-primary">#001</span></td>
                                <td>John Smith</td>
                                <td>$45.50</td>
                                <td><small class="text-muted">2 mins ago</small></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">#002</span></td>
                                <td>Mary Johnson</td>
                                <td>$123.20</td>
                                <td><small class="text-muted">15 mins ago</small></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">#003</span></td>
                                <td>Walk-in Customer</td>
                                <td>$67.80</td>
                                <td><small class="text-muted">28 mins ago</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Inventory Alerts</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <div>
                        <strong>15 items</strong> are running low on stock
                    </div>
                </div>
                
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Paracetamol 500mg</h6>
                            <small class="text-muted">Current stock: 12 units</small>
                        </div>
                        <span class="badge bg-warning">Low</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Amoxicillin 250mg</h6>
                            <small class="text-muted">Expires: Dec 28, 2024</small>
                        </div>
                        <span class="badge bg-danger">Expiring</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Vitamin C 1000mg</h6>
                            <small class="text-muted">Current stock: 8 units</small>
                        </div>
                        <span class="badge bg-warning">Low</span>
                    </div>
                </div>
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
                    <div class="col-md-4">
                        <a href="{{ route('pharmacist.drugs.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-capsule fs-1 mb-3"></i>
                            <span class="h6">Drug Inventory</span>
                            <small class="text-muted">Manage drug stock and information</small>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pharmacist.sales.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-cart-check fs-1 mb-3"></i>
                            <span class="h6">Sales Management</span>
                            <small class="text-muted">Process sales and view history</small>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pharmacist.purchases.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-bag fs-1 mb-3"></i>
                            <span class="h6">Purchase Orders</span>
                            <small class="text-muted">Manage supplier orders</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 