<nav class="nav flex-column p-3">
    <!-- Dashboard (all users) -->
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard
    </a>

    <!-- Admin Menu -->
    @if(auth()->user()->user_type === 'admin')
        <div class="nav-section mt-3">
            <h6 class="text-white-50 text-uppercase small fw-bold">Administration</h6>
            
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people me-2"></i>
                User Management
            </a>
            
            <a class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}" href="{{ route('admin.suppliers.index') }}">
                <i class="bi bi-truck me-2"></i>
                Suppliers
            </a>
            
            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <i class="bi bi-bar-chart me-2"></i>
                Reports & Analytics
            </a>
        </div>

        <div class="nav-section mt-3">
            <h6 class="text-white-50 text-uppercase small fw-bold">Inventory</h6>
            
            <a class="nav-link {{ request()->routeIs('drugs.*') ? 'active' : '' }}" href="{{ route('drugs.index') }}">
                <i class="bi bi-capsule me-2"></i>
                Drug Management
            </a>
            
            <a class="nav-link" href="#">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Expiry Alerts
            </a>
            
            <a class="nav-link" href="#">
                <i class="bi bi-box me-2"></i>
                Stock Levels
            </a>
        </div>
    @endif

    <!-- Pharmacist Menu -->
    @if(auth()->user()->user_type === 'pharmacist' || auth()->user()->user_type === 'admin')
        <div class="nav-section mt-3">
            <h6 class="text-white-50 text-uppercase small fw-bold">Operations</h6>
            
                            <a class="nav-link {{ request()->routeIs('drugs.*') ? 'active' : '' }}" href="{{ route('drugs.index') }}">
                    <i class="bi bi-capsule me-2"></i>
                    Drug Inventory
                </a>
                
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <i class="bi bi-truck me-2"></i>
                    Supplier Management
                </a>
                
                <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                    <i class="bi bi-cart-check me-2"></i>
                    Sales Processing
                </a>
                
                <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                    <i class="bi bi-bag me-2"></i>
                    Purchase Orders
                </a>
                
                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                    <i class="bi bi-laptop me-2"></i>
                    Online Orders
                    @php 
                        $pendingOrders = \App\Models\Sale::where('tipe_transaksi', 'online')
                                                         ->where('status_pesanan', 'pending')
                                                         ->count();
                    @endphp
                    @if($pendingOrders > 0)
                        <span class="badge bg-warning ms-2">{{ $pendingOrders }}</span>
                    @endif
                </a>
        </div>
    @endif

    <!-- Customer Menu -->
    @if(auth()->user()->user_type === 'customer')
        <div class="nav-section mt-3">
            <h6 class="text-white-50 text-uppercase small fw-bold">Shopping</h6>
            
            <a class="nav-link {{ request()->routeIs('customer.catalog.*') ? 'active' : '' }}" href="{{ route('customer.catalog.index') }}">
                <i class="bi bi-search me-2"></i>
                Drug Catalog
            </a>
            
            <a class="nav-link {{ request()->routeIs('customer.cart.*') ? 'active' : '' }}" href="{{ route('customer.cart.index') }}">
                <i class="bi bi-cart me-2"></i>
                Shopping Cart
                @php $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0; @endphp
                @if($cartCount > 0)
                    <span class="badge bg-danger ms-2">{{ $cartCount }}</span>
                @endif
            </a>
            
            <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                <i class="bi bi-bag-check me-2"></i>
                My Orders
            </a>
        </div>
    @endif

    <!-- Common Menu Items -->
    <div class="nav-section mt-3">
        <h6 class="text-white-50 text-uppercase small fw-bold">Account</h6>
        
        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
            <i class="bi bi-person me-2"></i>
            Profile Settings
        </a>
        
        <a class="nav-link" href="#">
            <i class="bi bi-question-circle me-2"></i>
            Help & Support
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="nav-section mt-4 pt-3 border-top border-light border-opacity-25">
        @if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'pharmacist')
            <button class="btn btn-outline-light btn-sm w-100 mb-2">
                <i class="bi bi-plus-lg me-2"></i>Quick Sale
            </button>
            <button class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-capsule me-2"></i>Add Drug
            </button>
        @endif
        
        @if(auth()->user()->user_type === 'customer')
            <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-light btn-sm w-100 mb-2">
                <i class="bi bi-cart me-2"></i>View Cart
                @php $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0; @endphp
                @if($cartCount > 0)
                    <span class="badge bg-danger ms-2">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('customer.catalog.index') }}" class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-search me-2"></i>Browse Catalog
            </a>
        @endif
    </div>

    <!-- User Info (mobile) -->
    <div class="nav-section mt-4 pt-3 border-top border-light border-opacity-25 d-md-none">
        <div class="d-flex align-items-center text-white">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=28a745&color=ffffff" 
                 alt="Avatar" class="rounded-circle me-2" width="32" height="32">
            <div>
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <small class="text-white-50">{{ ucfirst(Auth::user()->user_type) }}</small>
            </div>
        </div>
    </div>
</nav>
