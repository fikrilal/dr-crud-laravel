@extends('layouts.app')

@section('title', 'Sales History')

@push('styles')
<style>
/* Modern Sales Index Page Styles */
.modern-sales-header {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #e2e8f0;
}

.modern-stat-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.modern-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
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

/* Fix select dropdown styling */
.modern-form-control option {
    background: #334155 !important;
    color: #e2e8f0 !important;
    border: none !important;
}

/* Override modern form control for selects to prevent double styling */
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

.modern-form-label {
    color: #f8fafc;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.modern-form-select {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
    padding-right: 2.25rem !important;
}

.modern-form-select:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
}

.modern-form-select option {
    background: #334155 !important;
    color: #e2e8f0 !important;
}

.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #94a3b8 !important;
    border-radius: 8px 0 0 8px;
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
    background: #1e293b;
    color: #e2e8f0;
    margin: 0;
}

.modern-table thead th {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-bottom: 1px solid #334155 !important;
    border-top: none !important;
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
    padding: 1rem !important;
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

.modern-badge.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
    color: white !important;
}

.modern-badge.bg-light {
    background: #475569 !important;
    color: #e2e8f0 !important;
}

.modern-dropdown-menu {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
}

.modern-dropdown-item {
    color: #e2e8f0 !important;
    transition: all 0.2s ease;
}

.modern-dropdown-item:hover {
    background: #334155 !important;
    color: #f8fafc !important;
}

.modern-dropdown-divider {
    border-color: #334155 !important;
}

/* Stats Cards */
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
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header Section -->
    <div class="modern-sales-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Sales History</h2>
                    <p class="mb-0" style="color: #94a3b8;">Track and manage pharmacy sales transactions</p>
                </div>
            </div>
            <a href="{{ route('sales.create') }}" class="modern-btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Sale
            </a>
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
            <form method="GET" action="{{ route('sales.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="modern-form-label">Search Sales</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control modern-form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Transaction code, customer...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="modern-form-label">From Date</label>
                    <input type="date" class="form-control modern-form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="modern-form-label">To Date</label>
                    <input type="date" class="form-control modern-form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label for="payment_method" class="modern-form-label">Payment Method</label>
                    <select class="form-select modern-form-control" id="payment_method" name="payment_method">
                        <option value="">All Methods</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $method)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="modern-form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="modern-btn-outline">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('sales.index') }}" class="modern-btn-outline">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-primary">${{ number_format($sales->where('created_at', '>=', today())->sum('total_harga'), 2) }}</div>
                <div class="stats-label">Today's Revenue</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-success">{{ $sales->where('created_at', '>=', today())->count() }}</div>
                <div class="stats-label">Today's Transactions</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-info">${{ $sales->where('created_at', '>=', today())->count() > 0 ? number_format($sales->where('created_at', '>=', today())->avg('total_harga'), 2) : '0.00' }}</div>
                <div class="stats-label">Average Sale</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-warning">${{ number_format($sales->where('created_at', '>=', now()->startOfMonth())->sum('total_harga'), 2) }}</div>
                <div class="stats-label">This Month</div>
            </div>
        </div>
    </div>

    <!-- Modern Sales Table -->
    <div class="modern-card">
        <div class="modern-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-receipt-cutoff me-2"></i>Sales Transactions
                <span class="modern-badge bg-secondary ms-2">{{ $sales->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="modern-btn-outline" onclick="exportToExcel()" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="p-0">
            @if($sales->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table table mb-0">
                        <thead>
                            <tr>
                                <th width="15%">Transaction Code</th>
                                <th width="15%">Date & Time</th>
                                <th width="20%">Customer</th>
                                <th width="15%">Pharmacist</th>
                                <th width="10%">Items</th>
                                <th width="12%">Total</th>
                                <th width="8%">Payment</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>
                                        <span class="fw-bold" style="color: #3b82f6;">{{ $sale->kode_transaksi }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold" style="color: #f8fafc;">{{ $sale->created_at->format('M d, Y') }}</div>
                                            <small style="color: #94a3b8;">{{ $sale->created_at->format('H:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($sale->customer)
                                            <div>
                                                <div class="fw-bold" style="color: #f8fafc;">{{ $sale->customer->nama_pelanggan }}</div>
                                                <small style="color: #94a3b8;">{{ $sale->customer->nomor_telepon }}</small>
                                            </div>
                                        @else
                                            <span style="color: #94a3b8;">Walk-in Customer</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="bi bi-person-circle fs-5" style="color: #3b82f6;"></i>
                                            </div>
                                            <span style="color: #f8fafc;">{{ $sale->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="modern-badge bg-light">{{ $sale->saleDetails->count() }} items</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold" style="color: #10b981;">${{ number_format($sale->total_harga, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="modern-badge bg-primary">{{ ucfirst(str_replace('_', ' ', $sale->metode_pembayaran)) }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="modern-btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown" style="padding: 0.5rem;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu modern-dropdown-menu">
                                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('sales.show', $sale) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a></li>
                                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('sales.receipt', $sale) }}" target="_blank">
                                                    <i class="bi bi-receipt me-2"></i>Print Receipt
                                                </a></li>
                                                <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                                <li><a class="dropdown-item modern-dropdown-item" href="#" style="color: #94a3b8 !important;">
                                                    <i class="bi bi-arrow-clockwise me-2"></i>Refund (Coming Soon)
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modern Pagination -->
                <div class="p-3" style="background: #0f172a; border-top: 1px solid #334155;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div style="color: #94a3b8; font-size: 0.875rem;">
                            Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} results
                        </div>
                        <div>
                            {{ $sales->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5" style="color: #94a3b8;">
                    <i class="bi bi-receipt" style="font-size: 4rem; color: #475569; margin-bottom: 1rem;"></i>
                    <h5 class="fw-bold mb-2" style="color: #f8fafc;">No sales found</h5>
                    <p class="mb-4">
                        @if(request()->has('search') || request()->has('date_from') || request()->has('payment_method'))
                            Try adjusting your search criteria or <a href="{{ route('sales.index') }}" style="color: #3b82f6;">clear filters</a>
                        @else
                            Start by processing your first sale transaction
                        @endif
                    </p>
                    <a href="{{ route('sales.create') }}" class="modern-btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create First Sale
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportToExcel() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Auto-submit search form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodSelect = document.getElementById('payment_method');
    
    paymentMethodSelect.addEventListener('change', function() {
        this.form.submit();
    });

    // Set max date for date inputs to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_from').max = today;
    document.getElementById('date_to').max = today;
});
</script>
@endpush 