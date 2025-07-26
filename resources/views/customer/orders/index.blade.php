@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Customer /</span> My Orders
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('customer.catalog.index') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Shop More
            </a>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Orders List -->
        <div class="row">
            @foreach($orders as $order)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Order Info -->
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-1">Order #{{ $order->no_faktur }}</h5>
                                            <small class="text-muted">
                                                <i class="bx bx-calendar me-1"></i>
                                                Placed on {{ $order->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-label-{{ $order->status_pesanan == 'completed' ? 'success' : ($order->status_pesanan == 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($order->status_pesanan) }}
                                            </span>
                                            <div class="mt-1">
                                                <span class="badge bg-label-{{ $order->status_pembayaran == 'paid' ? 'success' : 'warning' }}">
                                                    Payment: {{ ucfirst($order->status_pembayaran) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    <div class="mb-3">
                                        <h6 class="mb-2">Items ({{ $order->details->count() }})</h6>
                                        <div class="row">
                                            @foreach($order->details->take(3) as $detail)
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge bg-label-primary me-2">{{ $detail->jumlah }}x</div>
                                                        <div>
                                                            <div class="fw-medium">{{ $detail->drug->nm_obat ?? 'N/A' }}</div>
                                                            <small class="text-muted">{{ $detail->drug->satuan ?? '' }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($order->details->count() > 3)
                                                <div class="col-md-4">
                                                    <small class="text-muted">+{{ $order->details->count() - 3 }} more items</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Delivery Address -->
                                    <div class="mb-2">
                                        <strong>Delivery Address:</strong>
                                        <div class="text-muted">{{ Str::limit($order->alamat_kirim, 100) }}</div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div>
                                        <strong>Payment:</strong>
                                        <span class="badge bg-label-secondary">
                                            {{ $order->metode_pembayaran == 'cash_on_delivery' ? 'Cash on Delivery' : 'Bank Transfer' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Order Total & Actions -->
                                <div class="col-md-4 text-end">
                                    <div class="mb-3">
                                        <h4 class="text-primary mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h4>
                                        <small class="text-muted">Total Amount</small>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('customer.orders.show', $order->no_faktur) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-detail me-1"></i>View Details
                                        </a>
                                        
                                        @if($order->status_pesanan == 'pending')
                                            <button class="btn btn-outline-warning btn-sm" disabled>
                                                <i class="bx bx-time me-1"></i>Awaiting Confirmation
                                            </button>
                                        @elseif($order->status_pesanan == 'processing')
                                            <button class="btn btn-outline-info btn-sm" disabled>
                                                <i class="bx bx-package me-1"></i>Being Prepared
                                            </button>
                                        @elseif($order->status_pesanan == 'shipped')
                                            <button class="btn btn-outline-success btn-sm" disabled>
                                                <i class="bx bx-truck me-1"></i>On Delivery
                                            </button>
                                        @endif
                                        
                                        <button class="btn btn-outline-secondary btn-sm" 
                                                onclick="reorderItems('{{ $order->no_faktur }}')">
                                            <i class="bx bx-refresh me-1"></i>Reorder
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-package display-1 text-muted mb-4"></i>
                <h4 class="mb-3">No orders yet</h4>
                <p class="text-muted mb-4">
                    You haven't placed any orders yet. Start shopping to see your orders here.
                </p>
                <a href="{{ route('customer.catalog.index') }}" class="btn btn-primary">
                    <i class="bx bx-search me-2"></i>Browse Catalog
                </a>
            </div>
        </div>
    @endif
</div>

<script>
function reorderItems(orderNo) {
    if (confirm('Add all items from this order to your cart?')) {
        // This would need to be implemented as a separate endpoint
        // For now, just redirect to catalog
        window.location.href = '{{ route("customer.catalog.index") }}';
    }
}
</script>
@endsection