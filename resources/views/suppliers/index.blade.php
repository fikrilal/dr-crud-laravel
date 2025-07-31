@extends('layouts.app')

@section('title', 'Supplier Management')

@push('styles')
<style>
/* Modern Supplier Management Page Styles */
.modern-suppliers-header {
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
    padding: 1.5rem;
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

.modern-btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
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

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
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

.stats-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.stats-avatar.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stats-avatar.bg-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stats-avatar.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
}

.stats-avatar.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
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
    font-weight: 500;
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
    vertical-align: middle;
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

.modern-badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white !important;
}

.modern-badge.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    color: white !important;
}

.modern-badge.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
    color: white !important;
}

.modern-badge.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    color: white !important;
}

.supplier-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #3b82f6;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 0.75rem;
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

/* Modern Modal Styles */
.modal-content {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 16px;
}

.modal-header {
    background: #0f172a;
    border-bottom: 1px solid #334155 !important;
    color: #f8fafc;
    border-radius: 16px 16px 0 0;
}

.modal-body {
    background: #1e293b;
    color: #e2e8f0;
}

.modal-footer {
    background: #1e293b;
    border-top: 1px solid #334155 !important;
    border-radius: 0 0 16px 16px;
}

.btn-close {
    filter: invert(1);
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header Section -->
    <div class="modern-suppliers-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Supplier Management</h2>
                    <p class="mb-0" style="color: #94a3b8;">Manage your pharmacy suppliers and their information</p>
                </div>
            </div>
            <a href="{{ route('admin.suppliers.create') }}" class="modern-btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Supplier
            </a>
        </div>
    </div>

    <!-- Modern Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-primary">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="stats-value">{{ $stats['total'] }}</div>
                <div class="stats-label">Total Suppliers</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-value">{{ $stats['active'] }}</div>
                <div class="stats-label">Active Suppliers</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-warning">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div class="stats-value">{{ $stats['inactive'] }}</div>
                <div class="stats-label">Inactive Suppliers</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-info">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="stats-value">{{ $stats['cities'] }}</div>
                <div class="stats-label">Cities Covered</div>
            </div>
        </div>
    </div>

    <!-- Modern Search and Filters -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>Search & Filter
            </h5>
        </div>
        <div class="modern-card-body">
            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="modern-form-label">Search Suppliers</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control modern-form-control" id="search" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by name, address, city, phone...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="status" class="modern-form-label">Status</label>
                    <select class="form-select modern-form-control" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="city" class="modern-form-label">City</label>
                    <input type="text" class="form-control modern-form-control" id="city" name="city" 
                           value="{{ request('city') }}" placeholder="Filter by city">
                </div>
                <div class="col-md-2">
                    <label class="modern-form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="modern-btn-outline">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        @if(request()->hasAny(['search', 'status', 'city']))
                            <a href="{{ route('admin.suppliers.index') }}" class="modern-btn-outline">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modern Suppliers Table -->
    <div class="modern-card">
        <div class="modern-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>Suppliers Directory
                <span class="modern-badge bg-secondary ms-2">{{ $suppliers->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="modern-btn-outline" onclick="exportSuppliers()" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="p-0">
            @if($suppliers->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table table mb-0">
                        <thead>
                            <tr>
                                <th width="8%">Code</th>
                                <th width="20%">Supplier Name</th>
                                <th width="25%">Address</th>
                                <th width="12%">City</th>
                                <th width="12%">Contact</th>
                                <th width="15%">Contact Person</th>
                                <th width="8%">Status</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                                <tr>
                                    <td><span class="fw-bold" style="color: #3b82f6;">{{ $supplier->kd_supplier }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="supplier-avatar">
                                                <i class="bi bi-truck"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="color: #f8fafc;">{{ $supplier->nama_supplier }}</div>
                                                <small style="color: #94a3b8;">{{ $supplier->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-wrap" style="max-width: 200px; color: #e2e8f0;">
                                            {{ $supplier->alamat }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="modern-badge bg-info">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $supplier->kota }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <small style="color: #94a3b8;" class="d-block">Phone:</small>
                                            <span class="fw-bold" style="color: #f8fafc;">{{ $supplier->nomor_telepon }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold" style="color: #f8fafc;">{{ $supplier->contact_person }}</span>
                                    </td>
                                    <td>
                                        @if($supplier->status === 'active')
                                            <span class="modern-badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="modern-badge bg-warning">
                                                <i class="bi bi-pause-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="modern-btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu modern-dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.suppliers.show', $supplier) }}">
                                                        <i class="bi bi-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.suppliers.edit', $supplier) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item modern-dropdown-item" style="color: #ef4444 !important;" onclick="confirmDelete('{{ $supplier->kd_supplier }}', '{{ $supplier->nama_supplier }}')">
                                                        <i class="bi bi-trash me-2"></i>Delete
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
                <div class="p-3" style="background: #0f172a; border-top: 1px solid #334155; border-radius: 0 0 16px 16px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div style="color: #94a3b8; font-size: 0.875rem;">
                            Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} suppliers
                        </div>
                        <div>
                            {{ $suppliers->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state-modern">
                    <div class="empty-state-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #f8fafc;">No Suppliers Found</h5>
                    <p class="mb-4">
                        @if(request()->hasAny(['search', 'status', 'city']))
                            No suppliers match your current filters. Try adjusting your search criteria.
                        @else
                            Start by adding your first supplier to the system.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'status', 'city']))
                        <a href="{{ route('admin.suppliers.index') }}" class="modern-btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                        </a>
                    @else
                        <a href="{{ route('admin.suppliers.create') }}" class="modern-btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add First Supplier
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel" style="color: #ef4444;">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete supplier <strong id="supplierName"></strong>?</p>
                <p style="color: #94a3b8;" class="small">This action cannot be undone. The supplier will only be deleted if it has no associated drugs or purchase orders.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="modern-btn-outline" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modern-btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Supplier
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(supplierId, supplierName) {
    document.getElementById('supplierName').textContent = supplierName;
    document.getElementById('deleteForm').action = `/admin/suppliers/${supplierId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function exportSuppliers() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Auto-submit filters on change
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endpush 