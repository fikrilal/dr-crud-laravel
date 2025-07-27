@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Order Management /</span> Order Details
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8 mb-4">
            <!-- Order Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Order #{{ $order->no_faktur }}</h5>
                            <div class="mb-2">
                                <strong>Order Date:</strong>
                                <span class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Customer:</strong>
                                <span class="text-muted">{{ $order->customer->nm_pelanggan ?? 'N/A' }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Customer ID:</strong>
                                <span class="text-muted">{{ $order->kd_pelanggan }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="mb-3">
                                <span class="badge bg-label-{{ $order->status_pesanan == 'completed' ? 'success' : ($order->status_pesanan == 'pending' ? 'warning' : ($order->status_pesanan == 'cancelled' ? 'danger' : 'info')) }} fs-6">
                                    {{ ucfirst($order->status_pesanan) }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-label-{{ $order->status_pembayaran == 'paid' ? 'success' : ($order->status_pembayaran == 'failed' ? 'danger' : 'warning') }} fs-6">
                                    Payment: {{ ucfirst($order->status_pembayaran) }}
                                </span>
                            </div>
                            <h4 class="text-primary mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h4>
                            <small class="text-muted">Total Amount</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($order->details as $detail)
                        <div class="border-bottom p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-1">{{ $detail->drug->nm_obat ?? 'Product N/A' }}</h6>
                                    <div class="text-muted">
                                        <span class="badge bg-label-primary me-2">{{ $detail->drug->jenis ?? 'N/A' }}</span>
                                        <span class="badge bg-label-secondary">{{ $detail->drug->satuan ?? 'N/A' }}</span>
                                    </div>
                                    @if($detail->drug && $detail->drug->description)
                                        <small class="text-muted d-block mt-1">{{ Str::limit($detail->drug->description, 100) }}</small>
                                    @endif
                                    @if($detail->drug)
                                        <small class="text-muted d-block">
                                            <strong>Current Stock:</strong> {{ $detail->drug->stok }} units
                                        </small>
                                    @endif
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="badge bg-label-info fs-6">{{ $detail->jumlah }}x</div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <strong>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</strong>
                                    <small class="text-muted d-block">per unit</small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <strong class="text-primary">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Delivery Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Delivery Address</h6>
                            <p class="text-muted">{{ $order->alamat_kirim }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Method</h6>
                            <div class="mb-3">
                                <span class="badge bg-label-secondary">
                                    {{ $order->metode_pembayaran == 'cash_on_delivery' ? 'Cash on Delivery' : 'Bank Transfer' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->catatan)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order Notes & History</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="white-space: pre-wrap; font-family: inherit;">{{ $order->catatan }}</pre>
                    </div>
                </div>
            @endif
        </div>

        <!-- Actions Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            @if($order->status_pesanan == 'pending')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 text-warning">
                            <i class="bx bx-time me-2"></i>Awaiting Confirmation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('orders.confirm', $order->no_faktur) }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('Confirm this order? This will move it to processing status.')">
                                    <i class="bx bx-check me-2"></i>Confirm Order
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-danger w-100" 
                                    onclick="rejectOrder('{{ $order->no_faktur }}')">
                                <i class="bx bx-x me-2"></i>Reject Order
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Management -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.updateStatus', $order->no_faktur) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status_pesanan" required>
                                <option value="pending" {{ $order->status_pesanan == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status_pesanan == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status_pesanan == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status_pesanan == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status_pesanan == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Add Note (Optional)</label>
                            <textarea class="form-control" name="notes" rows="2" 
                                      placeholder="Add status update note..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.updatePaymentStatus', $order->no_faktur) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="status_pembayaran" required>
                                <option value="pending" {{ $order->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status_pembayaran == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->status_pembayaran == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $order->status_pembayaran == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Payment</button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Items ({{ $order->details->count() }})</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery Fee</span>
                        <span class="text-success">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>Included</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Order Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Order #{{ $order->no_faktur }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST" action="{{ route('orders.reject', $order->no_faktur) }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <i class="bx bx-error-circle me-2"></i>
                        <strong>Warning:</strong> Rejecting this order will restore the stock for all items and mark the order as cancelled.
                    </div>
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
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection