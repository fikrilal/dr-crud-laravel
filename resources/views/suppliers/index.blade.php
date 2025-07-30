@extends('layouts.app')

@section('title', 'Supplier Management')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Supplier Management</li>
    @endsection
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-2">
                            <i class="bi bi-truck me-2"></i>Supplier Management
                        </h4>
                        <p class="card-text mb-0">Manage your pharmacy suppliers and their information.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-lg me-2"></i>Add New Supplier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-primary mb-2">
                    <i class="bi bi-truck display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['total'] }}</h5>
                <p class="card-text text-muted">Total Suppliers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-success mb-2">
                    <i class="bi bi-check-circle display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['active'] }}</h5>
                <p class="card-text text-muted">Active Suppliers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-warning mb-2">
                    <i class="bi bi-pause-circle display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['inactive'] }}</h5>
                <p class="card-text text-muted">Inactive Suppliers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-info mb-2">
                    <i class="bi bi-geo-alt display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['cities'] }}</h5>
                <p class="card-text text-muted">Cities Covered</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search Suppliers</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search by name, address, city, phone...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" 
                               value="{{ request('city') }}" placeholder="Filter by city">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Suppliers Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Suppliers List
                </h5>
                @if(request()->hasAny(['search', 'status', 'city']))
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-circle me-1"></i>Clear Filters
                    </a>
                @endif
            </div>
            <div class="card-body p-0">
                @if($suppliers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
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
                                        <td><span class="fw-bold text-primary">{{ $supplier->kd_supplier }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-truck text-primary"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $supplier->nama_supplier }}</div>
                                                    <small class="text-muted">{{ $supplier->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-wrap" style="max-width: 200px;">
                                                {{ $supplier->alamat }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $supplier->kota }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <small class="text-muted d-block">Phone:</small>
                                                <span class="fw-bold">{{ $supplier->nomor_telepon }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $supplier->contact_person }}</span>
                                        </td>
                                        <td>
                                            @if($supplier->status === 'active')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-pause-circle me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.suppliers.show', $supplier) }}">
                                                            <i class="bi bi-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.suppliers.edit', $supplier) }}">
                                                            <i class="bi bi-pencil me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button class="dropdown-item text-danger" onclick="confirmDelete('{{ $supplier->kd_supplier }}', '{{ $supplier->nama_supplier }}')">
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
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="text-muted">
                            Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} suppliers
                        </div>
                        {{ $suppliers->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-truck display-1 text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">No Suppliers Found</h4>
                        @if(request()->hasAny(['search', 'status', 'city']))
                            <p class="text-muted mb-4">No suppliers match your current filters.</p>
                            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-primary me-3">
                                <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                            </a>
                        @else
                            <p class="text-muted mb-4">Start by adding your first supplier to the system.</p>
                        @endif
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i>Add First Supplier
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete supplier <strong id="supplierName"></strong>?</p>
                <p class="text-muted small">This action cannot be undone. The supplier will only be deleted if it has no associated drugs or purchase orders.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
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

// Auto-submit filters on change
document.getElementById('status').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endpush 