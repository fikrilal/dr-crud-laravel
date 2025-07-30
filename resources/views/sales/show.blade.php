@extends('layouts.app')

@section('title', 'Sale Details')

@push('styles')
<style>
/* Modern Sales Detail Page Styles */
.modern-sales-header {
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
    padding: 2rem;
    color: #e2e8f0;
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

.modern-table {
    background: #1e293b !important;
    color: #e2e8f0 !important;
    margin: 0;
}

.modern-table thead th {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-bottom: 1px solid #334155 !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    padding: 1rem !important;
    font-weight: 600;
}

.modern-table tbody tr {
    background: #1e293b !important;
    border-bottom: 1px solid #334155 !important;
}

.modern-table tbody tr:hover {
    background: #334155 !important;
}

.modern-table tbody td {
    color: #e2e8f0 !important;
    border-color: #334155 !important;
    border-left: none !important;
    border-right: none !important;
    padding: 1rem !important;
}

.modern-table tfoot th {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-top: 1px solid #334155 !important;
    border-bottom: none !important;
    border-left: none !important;
    border-right: none !important;
    padding: 1rem !important;
    font-weight: 600;
}

/* Force override any Bootstrap table styles */
.table {
    --bs-table-bg: #1e293b !important;
    --bs-table-color: #e2e8f0 !important;
    --bs-table-border-color: #334155 !important;
    --bs-table-hover-bg: #334155 !important;
    --bs-table-hover-color: #f8fafc !important;
}

.table > :not(caption) > * > * {
    background-color: var(--bs-table-bg) !important;
    color: var(--bs-table-color) !important;
    border-bottom-color: var(--bs-table-border-color) !important;
}

.table > thead {
    background-color: #0f172a !important;
}

.table > thead th {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
}

.table > tfoot {
    background-color: #0f172a !important;
}

.table > tfoot th {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
}

.table-hover > tbody > tr:hover > * {
    background-color: var(--bs-table-hover-bg) !important;
    color: var(--bs-table-hover-color) !important;
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

.modern-badge.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
    color: white !important;
}

.modern-badge.bg-light {
    background: #475569 !important;
    color: #e2e8f0 !important;
}

.drug-avatar {
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

.info-section {
    padding: 1.5rem;
}

.info-item {
    margin-bottom: 1.5rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    color: #94a3b8;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.info-value {
    color: #f8fafc;
    font-weight: 600;
}

.empty-customer {
    text-align: center;
    padding: 2rem;
    color: #94a3b8;
}

.empty-customer-icon {
    font-size: 3rem;
    color: #475569;
    margin-bottom: 1rem;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Modern Header -->
            <div class="modern-sales-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Sale Transaction Details</h2>
                            <p class="mb-0" style="color: #94a3b8;">{{ $sale->kode_transaksi }} - {{ $sale->created_at->format('F d, Y H:i A') }}</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sales.receipt', $sale) }}" target="_blank" class="modern-btn-primary">
                            <i class="bi bi-receipt me-2"></i>Print Receipt
                        </a>
                        <a href="{{ route('sales.index') }}" class="modern-btn-outline">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Transaction Information -->
                <div class="col-lg-8">
                    <div class="modern-card mb-4">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-receipt-cutoff me-2"></i>Transaction Information
                            </h5>
                        </div>
                        <div class="modern-card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="info-label">Transaction Code</span>
                                        <div class="info-value" style="color: #3b82f6; font-size: 1.25rem;">{{ $sale->kode_transaksi }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="info-label">Transaction Date</span>
                                        <div class="info-value">{{ $sale->created_at->format('F d, Y H:i A') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="info-label">Payment Method</span>
                                        <div>
                                            <span class="modern-badge bg-primary">{{ ucfirst(str_replace('_', ' ', $sale->metode_pembayaran)) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="info-label">Status</span>
                                        <div>
                                            <span class="modern-badge bg-success">{{ ucfirst($sale->status) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="info-label">Pharmacist</span>
                                        <div class="d-flex align-items-center">
                                            <div class="drug-avatar me-2" style="width: 32px; height: 32px; font-size: 1rem;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <div class="info-value">{{ $sale->user->name }}</div>
                                                <small style="color: #94a3b8;">{{ $sale->user->email }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="info-label">Total Amount</span>
                                        <div class="info-value" style="color: #10b981; font-size: 1.5rem;">${{ number_format($sale->total_harga, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-bag me-2"></i>Sale Items
                                <span class="modern-badge bg-secondary ms-2">{{ $sale->saleDetails->count() }} items</span>
                            </h5>
                        </div>
                        <div class="p-0">
                            <div class="table-responsive">
                                <table class="modern-table table mb-0">
                                    <thead>
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
                                                        <div class="drug-avatar me-2" style="width: 32px; height: 32px; font-size: 1rem;">
                                                            <i class="bi bi-capsule-pill"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold" style="color: #f8fafc;">{{ $detail->drug->nama_obat }}</h6>
                                                            <small style="color: #94a3b8;">{{ $detail->drug->kategori }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="modern-badge bg-light">{{ $detail->drug->bentuk_obat }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold" style="color: #f8fafc;">{{ $detail->jumlah }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold" style="color: #f8fafc;">${{ number_format($detail->harga_satuan, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold" style="color: #10b981;">${{ number_format($detail->subtotal, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-end" style="color: #f8fafc;">Total Amount:</th>
                                            <th style="color: #10b981; font-size: 1.125rem;">${{ number_format($sale->total_harga, 2) }}</th>
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
                    <div class="modern-card mb-4">
                        <div class="modern-card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-person me-2"></i>Customer Information
                            </h6>
                        </div>
                        <div class="info-section">
                            @if($sale->customer)
                                <div class="info-item">
                                    <span class="info-label">Customer Name</span>
                                    <div class="info-value">{{ $sale->customer->nama_pelanggan }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Phone Number</span>
                                    <div class="info-value">{{ $sale->customer->nomor_telepon }}</div>
                                </div>

                                @if($sale->customer->alamat)
                                    <div class="info-item">
                                        <span class="info-label">Address</span>
                                        <div class="info-value">{{ $sale->customer->alamat }}</div>
                                    </div>
                                @endif

                                @if($sale->customer->tanggal_lahir)
                                    <div class="info-item">
                                        <span class="info-label">Date of Birth</span>
                                        <div class="info-value">{{ \Carbon\Carbon::parse($sale->customer->tanggal_lahir)->format('F d, Y') }}</div>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <span class="info-label">Customer Since</span>
                                    <div class="info-value">{{ $sale->customer->created_at->format('F Y') }}</div>
                                </div>
                            @else
                                <div class="empty-customer">
                                    <div class="empty-customer-icon">
                                        <i class="bi bi-person-x"></i>
                                    </div>
                                    <h6 style="color: #f8fafc; margin-bottom: 0.5rem;">Walk-in Customer</h6>
                                    <p class="mb-0" style="font-size: 0.875rem;">No customer information recorded for this transaction.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="modern-card mb-4">
                        <div class="modern-card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="modern-card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('sales.receipt', $sale) }}" target="_blank" class="modern-btn-primary">
                                    <i class="bi bi-receipt me-2"></i>Print Receipt
                                </a>
                                <a href="{{ route('sales.create') }}" class="modern-btn-outline">
                                    <i class="bi bi-plus-circle me-2"></i>New Sale
                                </a>
                                <button class="modern-btn-outline" onclick="alert('Refund functionality will be implemented in the next phase')" style="color: #fbbf24; border-color: #fbbf24;">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Process Refund
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Summary -->
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-calculator me-2"></i>Transaction Summary
                            </h6>
                        </div>
                        <div class="info-section">
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #94a3b8;">Total Items:</span>
                                <span class="fw-bold" style="color: #f8fafc;">{{ $sale->saleDetails->sum('jumlah') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #94a3b8;">Unique Drugs:</span>
                                <span class="fw-bold" style="color: #f8fafc;">{{ $sale->saleDetails->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #94a3b8;">Subtotal:</span>
                                <span class="fw-bold" style="color: #f8fafc;">${{ number_format($sale->total_harga, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #94a3b8;">Tax (0%):</span>
                                <span class="fw-bold" style="color: #f8fafc;">$0.00</span>
                            </div>
                            <hr style="border-color: #334155;">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold" style="color: #f8fafc;">Total Amount:</span>
                                <span class="fw-bold" style="color: #10b981; font-size: 1.25rem;">${{ number_format($sale->total_harga, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 