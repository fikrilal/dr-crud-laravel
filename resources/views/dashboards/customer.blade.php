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
                        <h2 class="mb-0">{{ number_format($stats['available_drugs']) }}</h2>
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
                        <h2 class="mb-0">{{ $stats['total_orders'] }}</h2>
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
                        <h6 class="card-title text-white-50">Cart Items</h6>
                        <h2 class="mb-0">{{ $stats['cart_count'] }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-cart"></i> 
                            @if($stats['cart_count'] > 0)
                                Ready to checkout
                            @else
                                No items
                            @endif
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-cart fs-1"></i>
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
                        <h6 class="card-title text-white-50">Total Spent</h6>
                        <h2 class="mb-0">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</h2>
                        <small class="text-white-50">
                            <i class="bi bi-wallet"></i> All time
                        </small>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-currency-dollar fs-1"></i>
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

<!-- Recent Orders & Cart Preview -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Orders</h5>
                <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                @if($stats['recent_orders']->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($stats['recent_orders']->take(3) as $order)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    @if($order->tipe_transaksi == 'online')
                                        <i class="bi bi-laptop"></i>
                                    @else
                                        <i class="bi bi-shop"></i>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-1">Order #{{ $order->nota }}</h6>
                                    <small class="text-muted">
                                        {{ $order->tipe_transaksi == 'online' ? 'Online Order' : 'Direct Purchase' }}
                                        • Rp {{ number_format($order->total_after_discount, 0, ',', '.') }}
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                @if($order->status_pesanan == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status_pesanan == 'confirmed')
                                    <span class="badge bg-info">Confirmed</span>
                                @elseif($order->status_pesanan == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->status_pesanan == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status_pesanan ?? 'Unknown') }}</span>
                                @endif
                                <br><small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-bag-x display-4 text-muted mb-2"></i>
                        <p class="text-muted">No orders yet</p>
                        <a href="{{ route('customer.catalog.index') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-search me-2"></i>Browse Catalog
                        </a>
                    </div>
                @endif
                
                @if($stats['pending_orders'] > 0)
                <div class="alert alert-info mt-3 mb-0">
                    <i class="bi bi-clock me-2"></i>
                    You have <strong>{{ $stats['pending_orders'] }}</strong> pending order(s) being processed.
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Shopping Cart</h5>
                <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-cart"></i> View Cart
                    @if($stats['cart_count'] > 0)
                        <span class="badge bg-danger ms-2">{{ $stats['cart_count'] }}</span>
                    @endif
                </a>
            </div>
            <div class="card-body">
                @if($stats['cart_count'] > 0)
                    <div class="alert alert-success d-flex align-items-center mb-3">
                        <i class="bi bi-cart-check me-2"></i>
                        <div>
                            You have <strong>{{ $stats['cart_count'] }}</strong> item(s) in your cart
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.cart.index') }}" class="btn btn-primary">
                            <i class="bi bi-eye me-2"></i>Review Cart
                        </a>
                        <a href="{{ route('customer.checkout') }}" class="btn btn-success">
                            <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-cart-x display-4 text-muted mb-2"></i>
                        <p class="text-muted">Your cart is empty</p>
                        <a href="{{ route('customer.catalog.index') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-search me-2"></i>Start Shopping
                        </a>
                    </div>
                @endif
                
                <!-- Quick Add Popular Items -->
                <hr class="my-3">
                <h6 class="text-muted small">Popular Items</h6>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="card border">
                            <div class="card-body p-2 text-center">
                                <i class="bi bi-capsule fs-5 text-primary mb-1"></i>
                                <h6 class="card-title small mb-1">Paracetamol</h6>
                                <small class="text-muted">Pain relief</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border">
                            <div class="card-body p-2 text-center">
                                <i class="bi bi-shield-plus fs-5 text-success mb-1"></i>
                                <h6 class="card-title small mb-1">Vitamin C</h6>
                                <small class="text-muted">Immunity</small>
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