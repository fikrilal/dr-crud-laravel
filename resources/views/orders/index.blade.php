@extends('layouts.app')

@push('styles')
<style>
/* Modern Orders Page Styles */
.modern-orders-header {
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

.form-select.modern-form-control:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
}

.form-select.modern-form-control option {
    background: #334155 !important;
    color: #e2e8f0 !important;
}

.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #94a3b8 !important;
    border-radius: 8px 0 0 8px;
}

.modern-form-label {
    color: #f8fafc;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
}

.modern-btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
}

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-outline {
    background: transparent;
    border: 1px solid #475569;
    color: #e2e8f0;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.modern-btn-outline:hover {
    background: #334155;
    border-color: #3b82f6;
    color: #e2e8f0;
    text-decoration: none;
}

.modern-btn-outline-primary {
    background: transparent;
    border: 1px solid #3b82f6;
    color: #3b82f6;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
}

.modern-btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
    text-decoration: none;
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

.modern-badge.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    color: white !important;
}

.modern-badge.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    color: white !important;
}

.modern-badge.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
    color: white !important;
}

.stats-card {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    color: #e2e8f0;
    transition: all 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
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
}

.order-card {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    border-color: #3b82f6;
}

.order-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
}

.empty-state-modern {
    padding: 4rem 2rem;
    text-align: center;
    color: #94a3b8;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

/* Modern Pagination Styles */
.pagination .page-link {
    background-color: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    margin: 0 2px !important;
    border-radius: 8px !important;
    padding: 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
}

.pagination .page-link:hover {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #f8fafc !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2) !important;
    text-decoration: none !important;
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
}

.pagination .page-item.disabled .page-link {
    background-color: #1e293b !important;
    border-color: #334155 !important;
    color: #64748b !important;
    cursor: not-allowed !important;
    opacity: 0.6 !important;
}

/* Modern Modal Styles */
.modal-content {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 16px;
}

.modal-header {
    background: #0f172a;
    border-bottom: 1px solid #334155 !important;
    color: #f8fafc;
    border-radius: 16px 16px 0 0;
}

.modal-body {
    background: #1e293b;
    color: #e2e8f0;
}

.modal-footer {
    background: #1e293b;
    border-top: 1px solid #334155 !important;
    border-radius: 0 0 16px 16px;
}

.btn-close {
    filter: invert(1);
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header Section -->
    <div class="modern-orders-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Online Orders</h2>
                    <p class="mb-0" style="color: #94a3b8;">Manage customer orders and fulfillment</p>
                </div>
            </div>
            <div class="modern-badge bg-primary fs-5">{{ $orders->total() }} total orders</div>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-warning">{{ $orders->where('status_pesanan', 'pending')->count() }}</div>
                <div class="stats-label">Pending Orders</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-info">{{ $orders->where('status_pesanan', 'processing')->count() }}</div>
                <div class="stats-label">Processing</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-success">{{ $orders->where('status_pesanan', 'completed')->count() }}</div>
                <div class="stats-label">Completed</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-success">Rp {{ number_format($orders->where('status_pesanan', 'completed')->sum('total_harga'), 0, ',', '.') }}</div>
                <div class="stats-label">Total Revenue</div>
            </div>
        </div>
    </div>

    <!-- Modern Search and Filter Section -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>Search & Filter
            </h5>
        </div>
        <div class="p-3">
            <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="modern-form-label">Search Orders</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control modern-form-control" name="search" 
                               value="{{ request('search') }}" placeholder="Order number or customer...">
                    </div>
                </div>

                <!-- Order Status Filter -->
                <div class="col-md-3">
                    <label class="modern-form-label">Order Status</label>
                    <select class="form-select modern-form-control" name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div class="col-md-3">
                    <label class="modern-form-label">Payment Status</label>
                    <select class="form-select modern-form-control" name="payment_status">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="modern-btn-outline">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <a href="{{ route('orders.index') }}" class="modern-btn-outline">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Modern Orders List -->
        <div class="modern-card">
            <div class="modern-card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Orders
                    <span class="modern-badge bg-secondary ms-2">{{ $orders->total() }} total</span>
                </h5>
                <small style="color: #94a3b8;">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </small>
            </div>
            <div class="p-0">
                @foreach($orders as $order)
                    <div class="order-card mx-3">
                        <div class="row align-items-center">
                            <!-- Order Info -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="order-avatar me-3">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('orders.show', $order->no_faktur) }}" class="fw-bold" style="color: #3b82f6; text-decoration: none;">
                                                Order #{{ $order->no_faktur }}
                                            </a>
                                        </h6>
                                        <small style="color: #94a3b8;">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Customer Info -->
                                <div class="mb-2">
                                    <strong style="color: #f8fafc;">Customer:</strong>
                                    <span style="color: #94a3b8;">{{ $order->customer->nm_pelanggan ?? 'N/A' }}</span>
                                </div>

                                <!-- Items Count -->
                                <div class="mb-2">
                                    <strong style="color: #f8fafc;">Items:</strong>
                                    <span class="modern-badge bg-info">{{ $order->details->count() }} items</span>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <strong style="color: #f8fafc;">Payment:</strong>
                                    <span class="modern-badge bg-secondary">
                                        {{ $order->metode_pembayaran == 'cash_on_delivery' ? 'Cash on Delivery' : 'Bank Transfer' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="col-md-3 text-center">
                                <div class="mb-2">
                                    @php
                                        $statusClass = match($order->status_pesanan) {
                                            'completed' => 'bg-success',
                                            'pending' => 'bg-warning',
                                            'cancelled' => 'bg-danger',
                                            'processing' => 'bg-info',
                                            'shipped' => 'bg-primary',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="modern-badge {{ $statusClass }} fs-6">
                                        {{ ucfirst($order->status_pesanan) }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    @php
                                        $paymentClass = match($order->status_pembayaran) {
                                            'paid' => 'bg-success',
                                            'failed' => 'bg-danger',
                                            default => 'bg-warning'
                                        };
                                    @endphp
                                    <span class="modern-badge {{ $paymentClass }}">
                                        Payment: {{ ucfirst($order->status_pembayaran) }}
                                    </span>
                                </div>

                                @if($order->status_pesanan == 'pending')
                                    <div class="d-grid gap-2">
                                        <form method="POST" action="{{ route('orders.confirm', $order->no_faktur) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="modern-btn-success w-100" 
                                                    onclick="return confirm('Confirm this order?')">
                                                <i class="bi bi-check me-1"></i>Confirm
                                            </button>
                                        </form>
                                        <button type="button" class="modern-btn-danger w-100" 
                                                onclick="rejectOrder('{{ $order->no_faktur }}')">
                                            <i class="bi bi-x me-1"></i>Reject
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Total & Details -->
                            <div class="col-md-3 text-end">
                                <div class="mb-3">
                                    <h5 class="mb-0" style="color: #10b981; font-size: 1.25rem; font-weight: 700;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
                                    <small style="color: #94a3b8;">Total Amount</small>
                                </div>

                                <div class="d-grid">
                                    <a href="{{ route('orders.show', $order->no_faktur) }}" 
                                       class="modern-btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modern Pagination -->
        <div class="p-3" style="background: #0f172a; border-top: 1px solid #334155; border-radius: 0 0 16px 16px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div style="color: #94a3b8; font-size: 0.875rem;">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </div>
                <div>
                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Modern Empty State -->
        <div class="modern-card">
            <div class="empty-state-modern">
                <div class="empty-state-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h4 class="fw-bold mb-3" style="color: #f8fafc;">No orders found</h4>
                <p class="mb-4">
                    @if(request()->hasAny(['search', 'status', 'payment_status']))
                        No orders match your current filters. Try adjusting your search criteria.
                    @else
                        No online orders have been placed yet. Orders will appear here once customers start placing them.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'payment_status']))
                    <a href="{{ route('orders.index') }}" class="modern-btn-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Modern Reject Order Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="modern-form-label">Reason for rejection *</label>
                        <textarea class="form-control modern-form-control" name="reason" rows="3" 
                                  placeholder="Enter reason for rejecting this order..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modern-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="modern-btn-danger">Reject Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function rejectOrder(orderNumber) {
    document.getElementById('rejectForm').action = `/orders/${orderNumber}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection