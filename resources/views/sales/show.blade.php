@extends('layouts.app')

@section('title', 'Sale Details')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales History</a></li>
        <li class="breadcrumb-item active">Sale Details</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Sale Transaction Details</h4>
                    <p class="text-muted mb-0">{{ $sale->kode_transaksi }} - {{ $sale->created_at->format('F d, Y H:i A') }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('sales.receipt', $sale) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-receipt me-2"></i>Print Receipt
                    </a>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Transaction Information -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-receipt-cutoff me-2"></i>Transaction Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Transaction Code</label>
                                    <div class="fw-bold text-primary fs-5">{{ $sale->kode_transaksi }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Transaction Date</label>
                                    <div class="fw-bold">{{ $sale->created_at->format('F d, Y H:i A') }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Payment Method</label>
                                    <div>
                                        <span class="badge bg-primary fs-6">{{ ucfirst(str_replace('_', ' ', $sale->metode_pembayaran)) }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Status</label>
                                    <div>
                                        <span class="badge bg-success fs-6">{{ ucfirst($sale->status) }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Pharmacist</label>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <i class="bi bi-person-circle text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $sale->user->name }}</div>
                                            <small class="text-muted">{{ $sale->user->email }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Total Amount</label>
                                    <div class="fw-bold text-success fs-4">${{ number_format($sale->total_harga, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-bag me-2"></i>Sale Items
                                <span class="badge bg-secondary ms-2">{{ $sale->saleDetails->count() }} items</span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Drug Name</th>
                                            <th>Form</th>
                                            <th width="10%">Quantity</th>
                                            <th width="15%">Unit Price</th>
                                            <th width="15%">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sale->saleDetails as $detail)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-wrapper me-2">
                                                            <div class="avatar avatar-sm">
                                                                <i class="bi bi-capsule-pill text-primary fs-5"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $detail->drug->nama_obat }}</h6>
                                                            <small class="text-muted">{{ $detail->drug->kategori }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $detail->drug->bentuk_obat }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold">{{ $detail->jumlah }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold">${{ number_format($detail->harga_satuan, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success">${{ number_format($detail->subtotal, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="4" class="text-end">Total Amount:</th>
                                            <th class="text-success">${{ number_format($sale->total_harga, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="col-lg-4">
                    <!-- Customer Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-person me-2"></i>Customer Information
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($sale->customer)
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Customer Name</label>
                                    <div class="fw-bold">{{ $sale->customer->nama_pelanggan }}</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Phone Number</label>
                                    <div class="fw-bold">{{ $sale->customer->nomor_telepon }}</div>
                                </div>

                                @if($sale->customer->alamat)
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Address</label>
                                        <div>{{ $sale->customer->alamat }}</div>
                                    </div>
                                @endif

                                @if($sale->customer->tanggal_lahir)
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Date of Birth</label>
                                        <div>{{ \Carbon\Carbon::parse($sale->customer->tanggal_lahir)->format('F d, Y') }}</div>
                                    </div>
                                @endif

                                <div class="mb-0">
                                    <label class="form-label text-muted small">Customer Since</label>
                                    <div>{{ $sale->customer->created_at->format('F Y') }}</div>
                                </div>
                            @else
                                <div class="text-center text-muted py-3">
                                    <i class="bi bi-person-x display-1 mb-2"></i>
                                    <h6>Walk-in Customer</h6>
                                    <p class="mb-0 small">No customer information recorded for this transaction.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('sales.receipt', $sale) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-receipt me-2"></i>Print Receipt
                                </a>
                                <a href="{{ route('sales.create') }}" class="btn btn-outline-success">
                                    <i class="bi bi-plus-circle me-2"></i>New Sale
                                </a>
                                <button class="btn btn-outline-warning" onclick="alert('Refund functionality will be implemented in the next phase')">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Process Refund
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-calculator me-2"></i>Transaction Summary
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Items:</span>
                                <span class="fw-bold">{{ $sale->saleDetails->sum('jumlah') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Unique Drugs:</span>
                                <span class="fw-bold">{{ $sale->saleDetails->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold">${{ number_format($sale->total_harga, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (0%):</span>
                                <span class="fw-bold">$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total Amount:</span>
                                <span class="fw-bold text-success fs-5">${{ number_format($sale->total_harga, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 