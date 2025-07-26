@extends('layouts.app')

@section('title', 'Purchase Order - ' . $purchase->nota)

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchase Orders</a></li>
        <li class="breadcrumb-item active">{{ $purchase->nota }}</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Purchase Details -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-cart-plus me-2"></i>Purchase Order Details
                    </h5>
                    <span class="badge bg-{{ $purchase->status_badge }} fs-6">
                        {{ ucfirst($purchase->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Purchase Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="fw-semibold">Purchase Number:</td>
                                    <td>{{ $purchase->nota }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Purchase Date:</td>
                                    <td>{{ $purchase->tgl_nota->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Created By:</td>
                                    <td>{{ $purchase->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Created At:</td>
                                    <td>{{ $purchase->created_at->format('F d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-building me-2"></i>Supplier Information
                                    </h6>
                                    <div class="fw-bold">{{ $purchase->supplier->nama_supplier }}</div>
                                    <div class="text-muted small">{{ $purchase->supplier->kd_supplier }}</div>
                                    <div class="mt-2">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $purchase->supplier->alamat_supplier }}
                                    </div>
                                    <div>
                                        <i class="bi bi-telephone me-1"></i>{{ $purchase->supplier->nomor_telepon }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($purchase->notes)
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-sticky me-2"></i>Notes
                                    </h6>
                                    {{ $purchase->notes }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Purchase Items -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Drug Name</th>
                                    <th>Form</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->purchaseDetails as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $detail->drug->nm_obat }}</div>
                                            <small class="text-muted">{{ $detail->drug->kd_obat }}</small>
                                        </td>
                                        <td>{{ $detail->drug->satuan }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ number_format($detail->jumlah) }}</span>
                                        </td>
                                        <td>${{ number_format($detail->harga_satuan, 2) }}</td>
                                        <td class="fw-semibold">${{ number_format($detail->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Total Items:</td>
                                    <td class="fw-semibold">{{ $purchase->total_items }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end fw-semibold">Subtotal:</td>
                                    <td class="fw-semibold">${{ number_format($purchase->total_before_discount, 2) }}</td>
                                </tr>
                                @if($purchase->diskon > 0)
                                    <tr>
                                        <td colspan="5" class="text-end fw-semibold">Discount:</td>
                                        <td class="fw-semibold text-danger">-${{ number_format($purchase->diskon, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="table-success">
                                    <td colspan="5" class="text-end fw-bold fs-5">Total Amount:</td>
                                    <td class="fw-bold fs-5">${{ number_format($purchase->total_after_discount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-gear me-2"></i>Actions
                    </h6>
                </div>
                <div class="card-body">
                    @if($purchase->status === 'pending')
                        <div class="d-grid gap-2">
                            <a href="{{ route('purchases.edit', $purchase->nota) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Purchase Order
                            </a>
                            
                            <form action="{{ route('purchases.receive', $purchase->nota) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('Mark this purchase as received? This will update drug stock and cannot be undone.')">
                                    <i class="bi bi-check-circle me-2"></i>Mark as Received
                                </button>
                            </form>
                            
                            <form action="{{ route('purchases.cancel', $purchase->nota) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100" 
                                        onclick="return confirm('Cancel this purchase order?')">
                                    <i class="bi bi-x-circle me-2"></i>Cancel Order
                                </button>
                            </form>
                            
                            <hr>
                            
                            <form action="{{ route('purchases.destroy', $purchase->nota) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Delete this purchase order permanently? This cannot be undone.')">
                                    <i class="bi bi-trash me-2"></i>Delete Order
                                </button>
                            </form>
                        </div>
                    @elseif($purchase->status === 'received')
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-check-circle me-2"></i>
                            This purchase order has been received and drug stock has been updated.
                        </div>
                    @elseif($purchase->status === 'cancelled')
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-x-circle me-2"></i>
                            This purchase order has been cancelled.
                        </div>
                    @endif
                    
                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left me-2"></i>Back to Purchase Orders
                    </a>
                </div>
            </div>

            <!-- Status History -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock me-2"></i>Status History
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Purchase Order Created</h6>
                                <p class="timeline-text text-muted small">
                                    {{ $purchase->created_at->format('F d, Y H:i:s') }}
                                    <br>by {{ $purchase->user->name }}
                                </p>
                            </div>
                        </div>
                        
                        @if($purchase->status === 'received')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Received</h6>
                                    <p class="timeline-text text-muted small">
                                        {{ $purchase->updated_at->format('F d, Y H:i:s') }}
                                        <br>Drug stock updated
                                    </p>
                                </div>
                            </div>
                        @elseif($purchase->status === 'cancelled')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Cancelled</h6>
                                    <p class="timeline-text text-muted small">
                                        {{ $purchase->updated_at->format('F d, Y H:i:s') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -26px;
    top: 20px;
    height: calc(100% - 10px);
    width: 2px;
    background-color: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.timeline-text {
    margin-bottom: 0;
    font-size: 0.8rem;
}
</style>
@endsection