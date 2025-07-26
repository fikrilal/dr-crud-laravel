@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Customer / Orders /</span> Order Details
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
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
                                <span class="text-muted">{{ $order->customer->nm_pelanggan ?? auth()->user()->name }}</span>
                            </div>
                            <div>
                                <strong>Email:</strong>
                                <span class="text-muted">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="mb-3">
                                <span class="badge bg-label-{{ $order->status_pesanan == 'completed' ? 'success' : ($order->status_pesanan == 'pending' ? 'warning' : 'info') }} fs-6">
                                    {{ ucfirst($order->status_pesanan) }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-label-{{ $order->status_pembayaran == 'paid' ? 'success' : 'warning' }} fs-6">
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
                            <h6>Delivery Status</h6>
                            <div class="mb-3">
                                @switch($order->status_pesanan)
                                    @case('pending')
                                        <div class="badge bg-label-warning">
                                            <i class="bx bx-time me-1"></i>Awaiting Confirmation
                                        </div>
                                        <p class="text-muted mt-2">Your order is being reviewed by our pharmacist.</p>
                                        @break
                                    @case('processing')
                                        <div class="badge bg-label-info">
                                            <i class="bx bx-package me-1"></i>Being Prepared
                                        </div>
                                        <p class="text-muted mt-2">Your order is being prepared for delivery.</p>
                                        @break
                                    @case('shipped')
                                        <div class="badge bg-label-primary">
                                            <i class="bx bx-truck me-1"></i>On Delivery
                                        </div>
                                        <p class="text-muted mt-2">Your order is on the way to your address.</p>
                                        @break
                                    @case('completed')
                                        <div class="badge bg-label-success">
                                            <i class="bx bx-check-circle me-1"></i>Delivered
                                        </div>
                                        <p class="text-muted mt-2">Your order has been successfully delivered.</p>
                                        @break
                                    @default
                                        <div class="badge bg-label-secondary">{{ ucfirst($order->status_pesanan) }}</div>
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->catatan)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order Notes</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">{{ $order->catatan }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Order Summary & Actions -->
        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card mb-4">
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

            <!-- Payment Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Payment Method:</strong>
                        <div class="mt-1">
                            <span class="badge bg-label-secondary">
                                {{ $order->metode_pembayaran == 'cash_on_delivery' ? 'Cash on Delivery' : 'Bank Transfer' }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Payment Status:</strong>
                        <div class="mt-1">
                            <span class="badge bg-label-{{ $order->status_pembayaran == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->status_pembayaran) }}
                            </span>
                        </div>
                    </div>
                    @if($order->status_pembayaran == 'pending' && $order->metode_pembayaran == 'bank_transfer')
                        <div class="alert alert-info" role="alert">
                            <i class="bx bx-info-circle me-2"></i>
                            <small>Bank transfer instructions have been sent to your email.</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($order->status_pesanan == 'completed')
                            <button class="btn btn-outline-primary" onclick="reorderItems()">
                                <i class="bx bx-refresh me-2"></i>Reorder Items
                            </button>
                        @endif
                        
                        <button class="btn btn-outline-secondary" onclick="contactSupport()">
                            <i class="bx bx-phone me-2"></i>Contact Support
                        </button>
                        
                        <button class="btn btn-outline-info" onclick="window.print()">
                            <i class="bx bx-printer me-2"></i>Print Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function reorderItems() {
    if (confirm('Add all items from this order to your cart?')) {
        // Redirect to catalog for now
        window.location.href = '{{ route("customer.catalog.index") }}';
    }
}

function contactSupport() {
    alert('Please call us at (555) 123-4567 or email support@pharmacy.com for assistance with order #{{ $order->no_faktur }}');
}
</script>
@endsection