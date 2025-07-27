@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Order Management /</span> Online Orders
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <div class="badge bg-primary fs-6">{{ $orders->total() }} total orders</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label">Search Orders</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-search-alt"></i></span>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" placeholder="Order number or customer...">
                    </div>
                </div>

                <!-- Order Status Filter -->
                <div class="col-md-3">
                    <label class="form-label">Order Status</label>
                    <select class="form-select" name="status">
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
                    <label class="form-label">Payment Status</label>
                    <select class="form-select" name="payment_status">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-search-alt"></i>
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-refresh"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Orders List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Orders</h5>
                <small class="text-muted">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </small>
            </div>
            <div class="card-body p-0">
                @foreach($orders as $order)
                    <div class="border-bottom p-4">
                        <div class="row align-items-center">
                            <!-- Order Info -->
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('orders.show', $order->no_faktur) }}" class="text-decoration-none">
                                                Order #{{ $order->no_faktur }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bx bx-calendar me-1"></i>
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Customer Info -->
                                <div class="mb-2">
                                    <strong>Customer:</strong>
                                    <span class="text-muted">{{ $order->customer->nm_pelanggan ?? 'N/A' }}</span>
                                </div>

                                <!-- Items Count -->
                                <div class="mb-2">
                                    <strong>Items:</strong>
                                    <span class="badge bg-label-info">{{ $order->details->count() }} items</span>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <strong>Payment:</strong>
                                    <span class="badge bg-label-secondary">
                                        {{ $order->metode_pembayaran == 'cash_on_delivery' ? 'Cash on Delivery' : 'Bank Transfer' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="col-md-3 text-center">
                                <div class="mb-2">
                                    <span class="badge bg-label-{{ $order->status_pesanan == 'completed' ? 'success' : ($order->status_pesanan == 'pending' ? 'warning' : ($order->status_pesanan == 'cancelled' ? 'danger' : 'info')) }} fs-6">
                                        {{ ucfirst($order->status_pesanan) }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-label-{{ $order->status_pembayaran == 'paid' ? 'success' : ($order->status_pembayaran == 'failed' ? 'danger' : 'warning') }}">
                                        Payment: {{ ucfirst($order->status_pembayaran) }}
                                    </span>
                                </div>

                                @if($order->status_pesanan == 'pending')
                                    <div class="d-grid gap-1">
                                        <form method="POST" action="{{ route('orders.confirm', $order->no_faktur) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success w-100" 
                                                    onclick="return confirm('Confirm this order?')">
                                                <i class="bx bx-check me-1"></i>Confirm
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger w-100" 
                                                onclick="rejectOrder('{{ $order->no_faktur }}')">
                                            <i class="bx bx-x me-1"></i>Reject
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Total & Details -->
                            <div class="col-md-3 text-end">
                                <div class="mb-3">
                                    <h5 class="text-primary mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
                                    <small class="text-muted">Total Amount</small>
                                </div>

                                <div class="d-grid gap-1">
                                    <a href="{{ route('orders.show', $order->no_faktur) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-detail me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-package display-1 text-muted mb-4"></i>
                <h4 class="mb-3">No orders found</h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['search', 'status', 'payment_status']))
                        No orders match your current filters.
                    @else
                        No online orders have been placed yet.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'payment_status']))
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">
                        <i class="bx bx-refresh me-2"></i>Clear Filters
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Reject Order Modal -->
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
                        <label class="form-label">Reason for rejection *</label>
                        <textarea class="form-control" name="reason" rows="3" 
                                  placeholder="Enter reason for rejecting this order..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Order</button>
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