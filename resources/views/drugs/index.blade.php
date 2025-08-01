@extends('layouts.app')

@section('title', 'Drug Management')

@push('styles')
<style>
/* Modern Drug Inventory Styles */
.modern-header {
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
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.modern-card-header {
    background: #0f172a;
    border-bottom: 1px solid #334155;
    padding: 1.5rem;
    color: #f8fafc;
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

.modern-form-label {
    color: #f8fafc;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

/* Fix select dropdown styling */
.modern-form-control option {
    background: #334155 !important;
    color: #e2e8f0 !important;
    border: none !important;
}

/* Input group styling */
.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #94a3b8 !important;
}

/* Ensure form controls maintain dark theme */
.form-control {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
}

.form-control:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
}

.form-control::placeholder {
    color: #94a3b8 !important;
}

.form-select {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
    padding-right: 2.25rem !important;
}

.form-select:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
}

.form-select option {
    background: #334155 !important;
    color: #e2e8f0 !important;
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
}

.modern-form-label {
    color: #f8fafc;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #94a3b8 !important;
    border-radius: 0 8px 8px 0 !important;
}

.input-group .modern-form-control {
    border-radius: 8px 0 0 8px !important;
}

.form-check-input {
    background-color: #334155 !important;
    border: 1px solid #475569 !important;
}

.form-check-input:checked {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
}

.form-check-label {
    color: #e2e8f0 !important;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.modern-btn-outline {
    background: transparent;
    border: 1px solid #475569;
    color: #e2e8f0;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.modern-btn-outline:hover {
    background: #334155;
    border-color: #3b82f6;
    color: #e2e8f0;
}

.modern-table {
    background: transparent !important;
    color: #e2e8f0 !important;
}

.modern-table th {
    background: #0f172a !important;
    border: none !important;
    color: #94a3b8 !important;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
}

.modern-table td {
    border: none !important;
    padding: 1rem;
    border-bottom: 1px solid #334155 !important;
    color: #e2e8f0 !important;
    vertical-align: middle;
    background: transparent !important;
}

.modern-table tbody tr {
    transition: all 0.2s ease;
    background: transparent !important;
}

.modern-table tbody tr:hover {
    background: #334155 !important;
}

/* Override Bootstrap table styles */
.table > :not(caption) > * > * {
    background-color: transparent !important;
    border-bottom-color: #334155 !important;
    color: #e2e8f0 !important;
}

.table-hover > tbody > tr:hover > * {
    background-color: #334155 !important;
}

/* Ensure table responsive wrapper doesn't interfere */
.table-responsive {
    background: transparent !important;
}

/* Override any Bootstrap table striped or other variants */
.table-striped > tbody > tr:nth-of-type(odd) > * {
    background-color: transparent !important;
}

.table > tbody {
    background-color: transparent !important;
}

.table > thead {
    background-color: transparent !important;
}

.modern-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success-modern {
    background: rgba(34, 197, 94, 0.2);
    color: #10b981;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.badge-warning-modern {
    background: rgba(251, 146, 60, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(251, 146, 60, 0.3);
}

.badge-danger-modern {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.badge-info-modern {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.badge-secondary-modern {
    background: rgba(148, 163, 184, 0.2);
    color: #94a3b8;
    border: 1px solid rgba(148, 163, 184, 0.3);
}

.drug-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
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
}

.stats-label {
    color: #94a3b8;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.modern-btn-outline-secondary {
    background: transparent;
    border: 1px solid #64748b;
    color: #64748b;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
}

.modern-btn-outline-secondary:hover {
    background: #64748b;
    color: white;
    text-decoration: none;
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

.modern-modal .modal-content {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 16px;
    color: #e2e8f0;
}

.modern-modal .modal-header {
    background: #0f172a;
    border-bottom: 1px solid #334155 !important;
    color: #f8fafc;
    border-radius: 16px 16px 0 0;
}

.modern-modal .modal-body {
    background: #1e293b;
    color: #e2e8f0;
}

.modern-modal .modal-footer {
    background: #1e293b;
    border-top: 1px solid #334155 !important;
    border-radius: 0 0 16px 16px;
}

.btn-close {
    filter: invert(1);
}

/* Modern Pagination Styles - Force Override Bootstrap */
.pagination {
    margin-bottom: 0 !important;
}

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

.pagination .page-link:focus {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #f8fafc !important;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.2) !important;
    text-decoration: none !important;
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
}

.pagination .page-item.active .page-link:hover {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
    color: #ffffff !important;
}

.pagination .page-item.disabled .page-link {
    background-color: #1e293b !important;
    border-color: #334155 !important;
    color: #64748b !important;
    cursor: not-allowed !important;
    opacity: 0.6 !important;
}

.pagination .page-item.disabled .page-link:hover {
    background-color: #1e293b !important;
    border-color: #334155 !important;
    color: #64748b !important;
    transform: none !important;
    box-shadow: none !important;
}

.pagination .page-item:first-child .page-link {
    border-top-left-radius: 8px !important;
    border-bottom-left-radius: 8px !important;
}

.pagination .page-item:last-child .page-link {
    border-top-right-radius: 8px !important;
    border-bottom-right-radius: 8px !important;
}

/* Additional overrides for any Bootstrap pagination variants */
.pagination .page-link[aria-label="Previous"],
.pagination .page-link[aria-label="Next"] {
    background-color: #334155 !important;
    border-color: #475569 !important;
    color: #e2e8f0 !important;
}

.pagination .page-link[aria-label="Previous"]:hover,
.pagination .page-link[aria-label="Next"]:hover {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #f8fafc !important;
}

/* Custom pagination container styling */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

@media (max-width: 768px) {
    .pagination {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.75rem;
    }
    
    .pagination .page-link {
        margin: 0 1px;
    }
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Header Section -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-2 fw-bold" style="color: #f8fafc;">Drug Management</h2>
                <p class="mb-0" style="color: #94a3b8;">Manage pharmacy inventory and drug information</p>
            </div>
            <div>
                <a href="{{ route('drugs.create') }}" class="modern-btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Drug
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value">{{ $drugs->total() }}</div>
                <div class="stats-label">Total Drugs</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-success">{{ $drugs->where('stok', '>', 10)->count() }}</div>
                <div class="stats-label">Well Stocked</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-warning">{{ $drugs->whereBetween('stok', [1, 10])->count() }}</div>
                <div class="stats-label">Low Stock</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-value text-danger">{{ $drugs->where('stok', '<=', 0)->count() }}</div>
                <div class="stats-label">Out of Stock</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>Search & Filter
            </h5>
        </div>
        <div class="p-3">
            <form method="GET" action="{{ route('drugs.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="modern-form-label">Search Drugs</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control modern-form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by name, category, form...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="category" class="modern-form-label">Category</label>
                    <select class="form-select modern-form-control" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="stock_status" class="modern-form-label">Stock Status</label>
                    <select class="form-select modern-form-control" id="stock_status" name="stock_status">
                        <option value="">All Stock</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (≤10)</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="modern-form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="modern-btn-outline">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('drugs.index') }}" class="modern-btn-outline">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Drugs Table -->
    <div class="modern-card">
        <div class="modern-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-capsule me-2"></i>Drug Inventory
                <span class="badge-info-modern modern-badge ms-2">{{ $drugs->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="modern-btn-outline" onclick="exportToExcel()">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="p-0">
            @if($drugs->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table table mb-0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Drug Name</th>
                                <th width="12%">Category</th>
                                <th width="10%">Form</th>
                                <th width="12%">Supplier</th>
                                <th width="8%">Stock</th>
                                <th width="10%">Price</th>
                                <th width="10%">Expiry</th>
                                <th width="8%">Status</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drugs as $drug)
                                <tr>
                                    <td><span style="color: #94a3b8;">#{{ $loop->iteration + ($drugs->currentPage() - 1) * $drugs->perPage() }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="drug-avatar me-3">
                                                <i class="bi bi-capsule-pill"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold" style="color: #f8fafc;">{{ $drug->nama_obat }}</h6>
                                                @if($drug->deskripsi)
                                                    <small style="color: #94a3b8;">{{ Str::limit($drug->deskripsi, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-info-modern modern-badge">{{ $drug->kategori }}</span>
                                    </td>
                                    <td style="color: #cbd5e1;">{{ $drug->bentuk_obat }}</td>
                                    <td>
                                        @if($drug->supplier)
                                            <span style="color: #94a3b8;">{{ $drug->supplier->nama_supplier }}</span>
                                        @else
                                            <span class="badge-danger-modern modern-badge">No Supplier</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($drug->stok <= 0)
                                            <span class="badge-danger-modern modern-badge">Out of Stock</span>
                                        @elseif($drug->stok <= $drug->stok_minimum)
                                            <span class="badge-warning-modern modern-badge">{{ $drug->stok }} (Low)</span>
                                        @else
                                            <span class="badge-success-modern modern-badge">{{ $drug->stok }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <small style="color: #94a3b8;">Buy: Rp{{ number_format($drug->harga_beli, 0, ',', '.') }}</small><br>
                                            <strong style="color: #f8fafc;">Sell: Rp{{ number_format($drug->harga_jual, 0, ',', '.') }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $expiryDate = \Carbon\Carbon::parse($drug->tanggal_kadaluarsa);
                                            $daysToExpiry = $expiryDate->diffInDays(now());
                                        @endphp
                                        @if($expiryDate->isPast())
                                            <span class="badge-danger-modern modern-badge">Expired</span>
                                        @elseif($daysToExpiry <= 30)
                                            <span class="badge-warning-modern modern-badge">{{ $daysToExpiry }}d left</span>
                                        @else
                                            <small style="color: #94a3b8;">{{ $expiryDate->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($drug->status === 'active')
                                            <span class="badge-success-modern modern-badge">Active</span>
                                        @else
                                            <span class="badge-secondary-modern modern-badge">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="modern-btn-outline-secondary dropdown-toggle" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu modern-dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('drugs.show', $drug) }}">
                                                        <i class="bi bi-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('drugs.edit', $drug) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit Drug
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item modern-dropdown-item stock-update-btn" 
                                                            data-drug-id="{{ $drug->kd_obat }}" 
                                                            data-drug-name="{{ $drug->nama_obat }}" 
                                                            data-current-stock="{{ $drug->stok }}">
                                                        <i class="bi bi-box me-2"></i>Update Stock
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item modern-dropdown-item delete-drug-btn" style="color: #ef4444 !important;" 
                                                            data-drug-id="{{ $drug->kd_obat }}" 
                                                            data-drug-name="{{ $drug->nama_obat }}">
                                                        <i class="bi bi-trash me-2"></i>Delete Drug
                                                    </button>
                                                </li>
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
                            Showing {{ $drugs->firstItem() }} to {{ $drugs->lastItem() }} of {{ $drugs->total() }} results
                        </div>
                        <div class="pagination-wrapper">
                            {{ $drugs->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state-modern">
                    <div class="empty-state-icon">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: #f8fafc;">No drugs found</h5>
                    <p class="mb-4">
                        @if(request()->has('search') || request()->has('category') || request()->has('stock_status'))
                            Try adjusting your search criteria or <a href="{{ route('drugs.index') }}" style="color: #3b82f6;">clear filters</a>
                        @else
                            Start by adding your first drug to the inventory
                        @endif
                    </p>
                    <a href="{{ route('drugs.create') }}" class="modern-btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add First Drug
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Enhanced Stock Update Modal -->
<div class="modal fade modern-modal" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #1e293b; border: 1px solid #334155; color: #e2e8f0;">
            <div class="modal-header" style="border-bottom: 1px solid #334155;">
                <h5 class="modal-title text-primary">
                    <i class="bi bi-box me-2"></i>Update Stock Inventory
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="stockForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-info" style="background: rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6; color: #60a5fa;">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Note:</strong> Changes will be logged for inventory tracking.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="modern-form-label">Drug Name</label>
                            <input type="text" class="modern-form-control" id="drugName" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="modern-form-label">Current Stock</label>
                            <div class="input-group">
                                <input type="number" class="modern-form-control" id="currentStock" readonly>
                                <span class="input-group-text" style="background: #475569; border: 1px solid #475569; color: #94a3b8;">units</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="modern-form-label">Operation Type</label>
                            <select class="form-select modern-form-control" id="type" name="type" required>
                                <option value="">Select operation...</option>
                                <option value="add">➕ Add Stock</option>
                                <option value="subtract">➖ Subtract Stock</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stockChange" class="modern-form-label">Quantity</label>
                            <div class="input-group">
                                <input type="number" class="modern-form-control" id="stockChange" name="stock_change" 
                                       required min="1" placeholder="Enter quantity">
                                <span class="input-group-text" style="background: #475569; border: 1px solid #475569; color: #94a3b8;">units</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="modern-form-label">Reason for Change</label>
                        <input type="text" class="modern-form-control" id="reason" name="reason" required 
                               placeholder="e.g., New delivery, Damaged goods, Sold items, etc.">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #334155;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Enhanced Delete Confirmation Modal -->
<div class="modal fade modern-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #1e293b; border: 1px solid #334155; color: #e2e8f0;">
            <div class="modal-header" style="border-bottom: 1px solid #334155;">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Drug Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" style="background: rgba(251, 191, 36, 0.1); border: 1px solid #f59e0b; color: #fbbf24;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                
                <div class="text-center mb-4">
                    <div class="empty-state-icon mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-capsule" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h5 style="color: #f8fafc;">Delete Drug from Inventory</h5>
                </div>
                
                <p>Are you sure you want to permanently delete the drug:</p>
                <div class="text-center p-3" style="background: #334155; border-radius: 8px; margin: 1rem 0;">
                    <strong id="deleteDrugName" style="color: #f8fafc; font-size: 1.1rem;"></strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        This will remove the drug from your inventory. Any associated transaction history will be preserved.
                    </small>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmDeletion" required>
                    <label class="form-check-label" for="confirmDeletion">
                        I understand that this action will permanently delete the drug from inventory.
                    </label>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #334155;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <form method="POST" id="deleteForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                        <i class="bi bi-trash me-2"></i>Delete Drug
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
console.log('Drug management JavaScript loaded');
console.log('Bootstrap available:', typeof bootstrap !== 'undefined');

function showStockModal(drugId, drugName, currentStock) {
    console.log('Showing stock modal for:', { drugId, drugName, currentStock });
    
    document.getElementById('stockForm').action = `drugs/${drugId}/stock`;
    document.getElementById('drugName').value = drugName;
    document.getElementById('currentStock').value = currentStock;
    document.getElementById('stockChange').value = '';
    document.getElementById('type').value = '';
    document.getElementById('reason').value = '';
    
    const bsModal = new bootstrap.Modal(document.getElementById('stockModal'));
    bsModal.show();
}

function confirmDelete(drugId, drugName) {
    console.log('Confirm delete for:', { drugId, drugName });
    console.log('Drug ID type:', typeof drugId, 'Drug ID value:', drugId);
    
    // Validate drugId
    if (!drugId || drugId === 'undefined' || drugId === '') {
        console.error('Invalid drug ID:', drugId);
        alert('Error: Invalid drug ID. Please refresh the page and try again.');
        return;
    }
    
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteDrugNameElement = document.getElementById('deleteDrugName');
    const confirmCheckbox = document.getElementById('confirmDeletion');
    const confirmButton = document.getElementById('confirmDeleteBtn');
    
    if (!modal || !deleteForm || !deleteDrugNameElement) {
        console.error('Required modal elements not found');
        alert('Error: Modal elements not found. Please refresh the page.');
        return;
    }
    
    // Set the form action and drug name
    const actionUrl = `drugs/${drugId}`;
    console.log('Setting form action to:', actionUrl);
    deleteForm.action = actionUrl;
    deleteDrugNameElement.textContent = drugName;
    
    // Reset checkbox and button state
    if (confirmCheckbox) {
        confirmCheckbox.checked = false;
    }
    if (confirmButton) {
        confirmButton.disabled = true;
    }
    
    // Show the modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

function exportToExcel() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Auto-submit search form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const stockStatusSelect = document.getElementById('stock_status');
    
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (stockStatusSelect) {
        stockStatusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    // Stock update button event listeners
    document.querySelectorAll('.stock-update-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const drugId = this.getAttribute('data-drug-id');
            const drugName = this.getAttribute('data-drug-name');
            const currentStock = this.getAttribute('data-current-stock');
            showStockModal(drugId, drugName, currentStock);
        });
    });
    
    // Delete drug button event listeners
    document.querySelectorAll('.delete-drug-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            console.log('Button HTML:', this.outerHTML);
            
            const drugId = this.getAttribute('data-drug-id');
            const drugName = this.getAttribute('data-drug-name');
            
            // Try alternative ways to get the drug ID
            const drugIdFromDataset = this.dataset.drugId;
            const drugIdDirectAttribute = this.getAttribute('data-drug-id');
            
            console.log('Delete button clicked - Drug ID:', drugId, 'Drug Name:', drugName);
            console.log('Drug ID from dataset:', drugIdFromDataset);
            console.log('Drug ID direct attribute:', drugIdDirectAttribute);
            console.log('Button element:', this);
            console.log('All data attributes:', this.dataset);
            console.log('All attributes:');
            for (let attr of this.attributes) {
                console.log(`  ${attr.name}: ${attr.value}`);
            }
            
            // Use the first non-empty value we can find
            const finalDrugId = drugId || drugIdFromDataset || drugIdDirectAttribute;
            console.log('Final drug ID to use:', finalDrugId);
            
            confirmDelete(finalDrugId, drugName);
        });
    });
    
    // Enable/disable delete button based on checkbox
    const confirmCheckbox = document.getElementById('confirmDeletion');
    const confirmButton = document.getElementById('confirmDeleteBtn');
    
    if (confirmCheckbox && confirmButton) {
        confirmCheckbox.addEventListener('change', function() {
            confirmButton.disabled = !this.checked;
            console.log('Delete checkbox changed:', this.checked);
        });
        
        // Form submission with loading state
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                console.log('Delete form submitted');
                console.log('Form action:', deleteForm.action);
                console.log('Form method:', deleteForm.method);
                
                // Additional debugging
                const methodInput = deleteForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    console.log('Method input value:', methodInput.value);
                } else {
                    console.log('No method input found');
                }
                
                const csrfInput = deleteForm.querySelector('input[name="_token"]');
                if (csrfInput) {
                    console.log('CSRF token found:', csrfInput.value.substring(0, 10) + '...');
                } else {
                    console.log('No CSRF token found');
                }
                
                confirmButton.disabled = true;
                confirmButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
            });
        }
    }
    
    // Stock form submission with loading state
    const stockForm = document.getElementById('stockForm');
    if (stockForm) {
        stockForm.addEventListener('submit', function(e) {
            const submitBtn = stockForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
            }
        });
    }
});
</script>
@endpush 