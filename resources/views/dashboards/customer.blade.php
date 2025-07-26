@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Customer Dashboard</li>
    @endsection
@endsection

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-2">Welcome, {{ Auth::user()->name }}!</h4>
                        <p class="card-text mb-0">Find the medications you need from our extensive pharmacy catalog.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button class="btn btn-light">
                            <i class="bi bi-search me-2"></i>Search Drugs
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card bg-primary text-white h-100">
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
        <div class="card stat-card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">My Orders</h6>
                        <h2 class="mb-0">12</h2>
                        <small class="text-white-50">
                            <i class="bi bi-clock-history"></i> Total orders
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-bag-check fs-1"></i>
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
                        <h6 class="card-title text-white-50">Favorites</h6>
                        <h2 class="mb-0">8</h2>
                        <small class="text-white-50">
                            <i class="bi bi-heart"></i> Saved items
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-star fs-1"></i>
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
                        <h6 class="card-title text-white-50">Categories</h6>
                        <h2 class="mb-0">24</h2>
                        <small class="text-white-50">
                            <i class="bi bi-grid"></i> Available
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-collection fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Search -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Find Your Medication</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search for drugs by name, category, or condition...">
                            <button class="btn btn-primary" type="button">Search</button>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">Popular searches: </small>
                            <a href="#" class="badge bg-light text-dark me-1">Paracetamol</a>
                            <a href="#" class="badge bg-light text-dark me-1">Vitamin C</a>
                            <a href="#" class="badge bg-light text-dark me-1">Cold Medicine</a>
                            <a href="#" class="badge bg-light text-dark me-1">Pain Relief</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.catalog.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-grid me-2"></i>Browse All Categories
                            </a>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-camera me-2"></i>Search by Photo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Featured Categories</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="#" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-heart-pulse fs-2 mb-2 text-danger"></i>
                            <span class="small">Pain Relief</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="#" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-shield-plus fs-2 mb-2 text-success"></i>
                            <span class="small">Vitamins</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="#" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-thermometer fs-2 mb-2 text-info"></i>
                            <span class="small">Cold & Flu</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="#" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-bandaid fs-2 mb-2 text-warning"></i>
                            <span class="small">First Aid</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="#" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-droplet fs-2 mb-2 text-primary"></i>
                            <span class="small">Antibiotics</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="#" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="bi bi-plus-circle fs-2 mb-2"></i>
                            <span class="small">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Favorites -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Orders</h5>
                <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-capsule"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Order #12345</h6>
                                <small class="text-muted">Paracetamol 500mg, Vitamin C</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success">Completed</span>
                            <br><small class="text-muted">Dec 20, 2024</small>
                        </div>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Order #12344</h6>
                                <small class="text-muted">Multivitamins, Omega-3</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning">Processing</span>
                            <br><small class="text-muted">Dec 18, 2024</small>
                        </div>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-info text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-thermometer"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Order #12343</h6>
                                <small class="text-muted">Cold medicine, Throat lozenges</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success">Completed</span>
                            <br><small class="text-muted">Dec 15, 2024</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">My Favorites</h5>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-heart"></i> Manage
                </button>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="card border">
                            <div class="card-body p-3 text-center">
                                <i class="bi bi-capsule fs-2 text-primary mb-2"></i>
                                <h6 class="card-title small mb-1">Paracetamol 500mg</h6>
                                <p class="text-muted small mb-2">$12.50</p>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border">
                            <div class="card-body p-3 text-center">
                                <i class="bi bi-shield-plus fs-2 text-success mb-2"></i>
                                <h6 class="card-title small mb-1">Vitamin C 1000mg</h6>
                                <p class="text-muted small mb-2">$18.75</p>
                                <button class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border">
                            <div class="card-body p-3 text-center">
                                <i class="bi bi-thermometer fs-2 text-info mb-2"></i>
                                <h6 class="card-title small mb-1">Cold Medicine</h6>
                                <p class="text-muted small mb-2">$24.30</p>
                                <button class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border">
                            <div class="card-body p-3 text-center">
                                <i class="bi bi-bandaid fs-2 text-warning mb-2"></i>
                                <h6 class="card-title small mb-1">First Aid Kit</h6>
                                <p class="text-muted small mb-2">$45.00</p>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
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
                        <a href="{{ route('customer.catalog.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-search fs-1 mb-3"></i>
                            <span class="h6">Browse Catalog</span>
                            <small class="text-muted">Search and explore all available drugs</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-bag-check fs-1 mb-3"></i>
                            <span class="h6">My Orders</span>
                            <small class="text-muted">View your order history and status</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-heart fs-1 mb-3"></i>
                            <span class="h6">Favorites</span>
                            <small class="text-muted">Manage your favorite medications</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                            <i class="bi bi-telephone fs-1 mb-3"></i>
                            <span class="h6">Contact Pharmacy</span>
                            <small class="text-muted">Get help and support</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 