@extends('layouts.app')

@section('title', 'Pharmacist Dashboard')

@push('styles')
<style>
/* Dashboard specific overrides */
.dashboard-modern {
    padding: 0;
}

.glass-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    color: #e2e8f0;
}

.glass-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
    border-color: #475569;
}

.metric-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 2rem;
    color: #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    border-radius: 16px 16px 0 0;
}

.metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
    border-color: #475569;
}

.metric-value {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin: 0.5rem 0;
    color: #f8fafc;
}

.metric-label {
    font-size: 0.9rem;
    color: #94a3b8;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.metric-change {
    font-size: 0.8rem;
    color: #cbd5e1;
    margin-top: 0.5rem;
}

.metric-icon {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    width: 60px;
    height: 60px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #3b82f6;
}

.content-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    color: #e2e8f0;
    overflow: hidden;
}

.content-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
    border-color: #475569;
}

.content-card .card-body {
    padding: 1.5rem;
}

.card-header-modern {
    background: transparent;
    border: none;
    padding: 1.5rem 1.5rem 1rem;
    margin-bottom: 0.5rem;
}

.card-title-modern {
    font-size: 1.1rem;
    font-weight: 600;
    color: #f8fafc;
    margin: 0;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-online {
    background: #3b82f6;
    color: white;
}

.badge-direct {
    background: #8b5cf6;
    color: white;
}

.table-modern {
    border: none;
    color: #e2e8f0;
    background: transparent;
    margin: 0;
}

.table-responsive {
    margin-top: 0.5rem;
}

.table-modern th {
    border: none;
    color: #94a3b8;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1.5rem;
    background: #0f172a;
}

.table-modern td {
    border: none;
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #334155;
    color: #e2e8f0;
    background: transparent;
}

.table-modern tbody tr {
    background: transparent;
}

.table-modern tbody tr:hover {
    background: #334155;
}

/* Fix specific table elements */
.table-modern .fw-bold {
    color: #f8fafc !important;
}

.table-modern .text-primary {
    color: #3b82f6 !important;
}

.table-modern .text-muted {
    color: #94a3b8 !important;
}

.empty-state {
    padding: 3rem 2rem;
    text-align: center;
    color: #94a3b8;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.quick-action {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 1.5rem;
    text-decoration: none;
    color: #e2e8f0;
    transition: all 0.3s ease;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    height: 100%;
    margin-top: 0.5rem;
}

.quick-action:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
    color: #e2e8f0;
    text-decoration: none;
    background: #475569;
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.quick-action-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
}

.quick-action-title {
    font-size: 1rem;
    font-weight: 600;
    color: #f8fafc;
    margin: 0;
    line-height: 1.3;
}

.quick-action-desc {
    font-size: 0.875rem;
    color: #94a3b8;
    line-height: 1.4;
    margin: 0;
}

.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    border-left: 4px solid;
    margin-bottom: 1rem;
}

.alert-warning-modern {
    background: rgba(251, 146, 60, 0.1);
    border-left-color: #f59e0b;
    color: #fbbf24;
}

.alert-success-modern {
    background: rgba(34, 197, 94, 0.1);
    border-left-color: #22c55e;
    color: #10b981;
}

.inventory-item {
    padding: 1rem;
    border-radius: 8px;
    background: #334155;
    border: 1px solid #475569;
    margin-bottom: 0.75rem;
    transition: all 0.2s ease;
    color: #e2e8f0;
}

.inventory-item:hover {
    background: #475569;
    border-color: #64748b;
}

.inventory-item:first-child {
    margin-top: 0.5rem;
}

.stock-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.stock-critical {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.stock-low {
    background: rgba(251, 146, 60, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(251, 146, 60, 0.3);
}

.stock-out {
    background: #991b1b;
    color: white;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeInUp 0.6s ease-out;
}

.animate-delay-1 { animation-delay: 0.1s; }
.animate-delay-2 { animation-delay: 0.2s; }
.animate-delay-3 { animation-delay: 0.3s; }
.animate-delay-4 { animation-delay: 0.4s; }
</style>
@endpush

@section('content')
<div class="dashboard-modern">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-4 animate-fade-in">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2 fw-bold" style="color: #f8fafc;">Good {{ \Carbon\Carbon::now()->format('A') === 'AM' ? 'Morning' : 'Afternoon' }}, {{ Auth::user()->name }}!</h1>
                        <p class="mb-0 fs-5" style="color: #94a3b8;">Ready to serve customers and manage pharmacy operations</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="fs-6" style="color: #94a3b8;">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</div>
                        <div class="fs-4 fw-bold" style="color: #f8fafc;" id="live-clock"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Metrics Cards -->
        <div class="row" style="margin-bottom: 3rem;">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="metric-card animate-fade-in animate-delay-1">
                    <div class="metric-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="metric-label">Today's Revenue</div>
                    <div class="metric-value">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</div>
                    <div class="metric-change">
                        <i class="bi bi-arrow-up me-1"></i>{{ $stats['today_sales'] }} transactions
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="metric-card animate-fade-in animate-delay-2">
                    <div class="metric-icon">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                    <div class="metric-label">This Week</div>
                    <div class="metric-value">Rp {{ number_format($stats['week_revenue'], 0, ',', '.') }}</div>
                    <div class="metric-change">
                        <i class="bi bi-check-circle me-1"></i>{{ $stats['week_sales'] }} sales
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="metric-card animate-fade-in animate-delay-3">
                    <div class="metric-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="metric-label">Low Stock Items</div>
                    <div class="metric-value">{{ $stats['low_stock_count'] }}</div>
                    <div class="metric-change">
                        @if($stats['low_stock_count'] > 0)
                            <i class="bi bi-exclamation-triangle me-1"></i>Need attention
                        @else
                            <i class="bi bi-check-circle me-1"></i>All stocked
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="metric-card animate-fade-in animate-delay-4">
                    <div class="metric-icon">
                        <i class="bi bi-hourglass"></i>
                    </div>
                    <div class="metric-label">Pending Orders</div>
                    <div class="metric-value">{{ $stats['pending_orders'] }}</div>
                    <div class="metric-change">
                        @if($stats['pending_orders'] > 0)
                            <i class="bi bi-clock me-1"></i>Need processing
                        @else
                            <i class="bi bi-check-circle me-1"></i>All processed
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row" style="margin-bottom: 2rem;">
            <!-- Recent Sales -->
            <div class="col-lg-8 mb-4">
                <div class="content-card animate-fade-in">
                    <div class="card-header-modern d-flex justify-content-between align-items-center">
                        <h5 class="card-title-modern">Recent Sales Activity</h5>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; border: none; border-radius: 8px; padding: 0.5rem 1rem;">
                            View All
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($stats['recent_sales']->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern">
                                    <thead>
                                        <tr>
                                            <th>Receipt</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stats['recent_sales']->take(5) as $sale)
                                        <tr>
                                            <td>
                                                <span class="fw-bold text-primary">#{{ $sale->nota }}</span>
                                            </td>
                                            <td>
                                                @if($sale->tipe_transaksi == 'online')
                                                    <span class="status-badge badge-online">Online</span>
                                                @else
                                                    <span class="status-badge badge-direct">Direct</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold">Rp {{ number_format($sale->total_after_discount, 0, ',', '.') }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $sale->created_at->diffForHumans() }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-cart-x"></i>
                                </div>
                                <h6 class="fw-bold mb-2">No Recent Sales</h6>
                                <p class="mb-3">Start processing sales to see activity here</p>
                                <a href="{{ route('sales.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; border: none; border-radius: 8px; padding: 0.75rem 1.5rem;">
                                    <i class="bi bi-plus me-2"></i>Create Sale
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Inventory Alerts -->
            <div class="col-lg-4 mb-4">
                <div class="content-card animate-fade-in">
                    <div class="card-header-modern d-flex justify-content-between align-items-center">
                        <h5 class="card-title-modern">Inventory Alerts</h5>
                        <a href="{{ route('expiry-alerts.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @if($stats['low_stock_count'] > 0 || $stats['out_of_stock_count'] > 0)
                            <div class="alert-modern alert-warning-modern mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <div>
                                        @if($stats['out_of_stock_count'] > 0)
                                            <strong>{{ $stats['out_of_stock_count'] }}</strong> items out of stock
                                        @endif
                                        @if($stats['low_stock_count'] > 0)
                                            <strong>{{ $stats['low_stock_count'] }}</strong> items running low
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert-modern alert-success-modern mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <div>All inventory levels are optimal</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($stats['low_stock_drugs']->count() > 0)
                            @foreach($stats['low_stock_drugs']->take(4) as $drug)
                            <div class="inventory-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $drug->nm_obat }}</h6>
                                        <small class="text-muted">Stock: {{ $drug->stok }} units</small>
                                    </div>
                                    <div>
                                        @if($drug->stok <= 0)
                                            <span class="stock-badge stock-out">Out</span>
                                        @elseif($drug->stok <= 5)
                                            <span class="stock-badge stock-critical">Critical</span>
                                        @else
                                            <span class="stock-badge stock-low">Low</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($stats['low_stock_drugs']->count() > 4)
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    And {{ $stats['low_stock_drugs']->count() - 4 }} more items
                                </small>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="content-card animate-fade-in">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('drugs.index') }}" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="bi bi-capsule"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <div class="quick-action-title">Drug Inventory</div>
                                        <div class="quick-action-desc">Manage drug stock and information</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('sales.index') }}" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="bi bi-cart-check"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <div class="quick-action-title">Sales Management</div>
                                        <div class="quick-action-desc">Process sales and view history</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('purchases.index') }}" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="bi bi-bag"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <div class="quick-action-title">Purchase Orders</div>
                                        <div class="quick-action-desc">Manage supplier orders</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('orders.index') }}" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="bi bi-laptop"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <div class="quick-action-title">Online Orders</div>
                                        <div class="quick-action-desc">Process customer orders</div>
                                    </div>
                                </a>
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
// Live Clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
        hour12: false,
        hour: '2-digit',
        minute: '2-digit'
    });
    document.getElementById('live-clock').textContent = timeString;
}

// Update clock every second
updateClock();
setInterval(updateClock, 1000);

// Smooth animations on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards
document.querySelectorAll('.content-card, .metric-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.6s ease';
    observer.observe(card);
});

// Auto-refresh data every 5 minutes
setInterval(function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 300000);
</script>
@endpush