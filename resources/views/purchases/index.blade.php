@extends('layouts.app')

@section('title', 'Purchase Orders')

@push('styles')
<style>
/* Modern Purchase Orders Page Styles */
.modern-purchases-header {
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

.modern-badge.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    color: white !important;
}

.modern-badge.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
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

.purchase-avatar {
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
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header Section -->
    <div class="modern-purchases-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-cart-plus"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Purchase Orders</h2>
                    <p class="mb-0" style="color: #94a3b8;">Manage inventory purchases and supplier orders</p>
                </div>
            </div>
            <a href="{{ route('purchases.create') }}" class="modern-btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Purchase Order
            </a>
        </div>
    </div>

    <!-- Purchase Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-primary">{{ $purchases->where('status', 'pending')->count() }}</div>
                <div class="stats-label">Pending Orders</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-success">{{ $purchases->where('status', 'received')->count() }}</div>
                <div class="stats-label">Received Orders</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-warning">{{ $purchases->where('status', 'cancelled')->count() }}</div>
                <div class="stats-label">Cancelled Orders</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-info">${{ number_format($purchases->where('status', 'received')->sum('total_after_discount'), 2) }}</div>
                <div class="stats-label">Total Received Value</div>
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
            <form method="GET" action="{{ route('purchases.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="modern-form-label">Search Orders</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control modern-form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Purchase number, supplier...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="status" class="modern-form-label">Status</label>
                    <select class="form-select modern-form-control" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="supplier" class="modern-form-label">Supplier</label>
                    <select class="form-select modern-form-control" id="supplier" name="supplier">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->kd_supplier }}" {{ request('supplier') == $supplier->kd_supplier ? 'selected' : '' }}>
                                {{ $supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="modern-form-label">From Date</label>
                    <input type="date" class="form-control modern-form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="modern-form-label">To Date</label>
                    <input type="date" class="form-control modern-form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <label class="modern-form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="modern-btn-outline">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('purchases.index') }}" class="modern-btn-outline">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modern Purchase Orders Table -->
    <div class="modern-card">
        <div class="modern-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-cart-plus me-2"></i>Purchase Orders
                <span class="modern-badge bg-secondary ms-2">{{ $purchases->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="modern-btn-outline" onclick="exportToExcel()" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="p-0">
            <div class="table-responsive">
                <table class="modern-table table">
                    <thead>
                        <tr>
                            <th>Purchase #</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>
                                    <a href="{{ route('purchases.show', $purchase->nota) }}" class="fw-bold" style="color: #3b82f6; text-decoration: none;">
                                        {{ $purchase->nota }}
                                    </a>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold" style="color: #f8fafc;">{{ $purchase->tgl_nota->format('M d, Y') }}</div>
                                        <small style="color: #94a3b8;">{{ $purchase->tgl_nota->format('H:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="purchase-avatar me-2" style="width: 32px; height: 32px; font-size: 1rem;">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="color: #f8fafc;">{{ $purchase->supplier->nama_supplier }}</div>
                                            <small style="color: #94a3b8;">{{ $purchase->supplier->kd_supplier }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="modern-badge bg-light">{{ $purchase->total_items }} items</span>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold" style="color: #10b981;">${{ number_format($purchase->total_after_discount, 2) }}</div>
                                        @if($purchase->diskon > 0)
                                            <small style="color: #94a3b8; text-decoration: line-through;">
                                                ${{ number_format($purchase->total_before_discount, 2) }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($purchase->status) {
                                            'pending' => 'bg-warning',
                                            'received' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="modern-badge {{ $statusClass }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="purchase-avatar me-2" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <small style="color: #94a3b8;">{{ $purchase->user->name }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="modern-btn-outline dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown" style="padding: 0.5rem;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu modern-dropdown-menu">
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item" href="{{ route('purchases.show', $purchase->nota) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            @if($purchase->status === 'pending')
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('purchases.edit', $purchase->nota) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('purchases.receive', $purchase->nota) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item modern-dropdown-item" style="color: #10b981 !important;" 
                                                                onclick="return confirm('Mark this purchase as received? This will update drug stock.')">
                                                            <i class="bi bi-check-circle me-2"></i>Mark as Received
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('purchases.cancel', $purchase->nota) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item modern-dropdown-item" style="color: #fbbf24 !important;" 
                                                                onclick="return confirm('Cancel this purchase order?')">
                                                            <i class="bi bi-x-circle me-2"></i>Cancel
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('purchases.destroy', $purchase->nota) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item modern-dropdown-item" style="color: #ef4444 !important;" 
                                                                onclick="return confirm('Delete this purchase order permanently?')">
                                                            <i class="bi bi-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state-modern">
                                        <div class="empty-state-icon">
                                            <i class="bi bi-cart-plus"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #f8fafc;">No purchase orders found</h5>
                                        <p class="mb-4">
                                            @if(request()->has('search') || request()->has('status') || request()->has('supplier'))
                                                Try adjusting your search criteria or <a href="{{ route('purchases.index') }}" style="color: #3b82f6;">clear filters</a>
                                            @else
                                                Start by creating your first purchase order to manage inventory
                                            @endif
                                        </p>
                                        <a href="{{ route('purchases.create') }}" class="modern-btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Create First Purchase Order
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modern Pagination -->
            @if($purchases->hasPages())
                <div class="p-3" style="background: #0f172a; border-top: 1px solid #334155;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div style="color: #94a3b8; font-size: 0.875rem;">
                            Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} results
                        </div>
                        <div>
                            {{ $purchases->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportToExcel() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Auto-submit search form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const supplierSelect = document.getElementById('supplier');
    
    statusSelect.addEventListener('change', function() {
        this.form.submit();
    });
    
    supplierSelect.addEventListener('change', function() {
        this.form.submit();
    });

    // Set max date for date inputs to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_from').max = today;
    document.getElementById('date_to').max = today;
});
</script>
@endpush
@endsection