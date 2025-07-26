@extends('layouts.app')

@section('title', 'Drug Management')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Drug Management</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Drug Management</h4>
                    <p class="text-muted mb-0">Manage pharmacy inventory and drug information</p>
                </div>
                <div>
                    <a href="{{ route('drugs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add New Drug
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('drugs.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Drugs</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by name, category, form...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="stock_status" class="form-label">Stock Status</label>
                    <select class="form-select" id="stock_status" name="stock_status">
                        <option value="">All Stock</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (≤10)</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('drugs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Drugs Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-capsule me-2"></i>Drug Inventory
                <span class="badge bg-secondary ms-2">{{ $drugs->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-success" onclick="exportToExcel()">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if($drugs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
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
                                    <td>{{ $loop->iteration + ($drugs->currentPage() - 1) * $drugs->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-2">
                                                <div class="avatar avatar-sm">
                                                    <i class="bi bi-capsule-pill text-primary fs-5"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $drug->nama_obat }}</h6>
                                                @if($drug->deskripsi)
                                                    <small class="text-muted">{{ Str::limit($drug->deskripsi, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $drug->kategori }}</span>
                                    </td>
                                    <td>{{ $drug->bentuk_obat }}</td>
                                    <td>
                                        @if($drug->supplier)
                                            <small class="text-muted">{{ $drug->supplier->nama_supplier }}</small>
                                        @else
                                            <span class="text-danger">No Supplier</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($drug->stok <= 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($drug->stok <= $drug->stok_minimum)
                                            <span class="badge bg-warning">{{ $drug->stok }} (Low)</span>
                                        @else
                                            <span class="badge bg-success">{{ $drug->stok }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <small class="text-muted">Buy: ${{ number_format($drug->harga_beli, 2) }}</small><br>
                                            <strong>Sell: ${{ number_format($drug->harga_jual, 2) }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $expiryDate = \Carbon\Carbon::parse($drug->tanggal_kadaluarsa);
                                            $daysToExpiry = $expiryDate->diffInDays(now());
                                        @endphp
                                        @if($expiryDate->isPast())
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($daysToExpiry <= 30)
                                            <span class="badge bg-warning">{{ $daysToExpiry }}d left</span>
                                        @else
                                            <small class="text-muted">{{ $expiryDate->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($drug->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('drugs.show', $drug) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('drugs.edit', $drug) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit Drug
                                                </a></li>
                                                <li><button class="dropdown-item" onclick="showStockModal({{ $drug->id }}, '{{ $drug->nama_obat }}', {{ $drug->stok }})">
                                                    <i class="bi bi-box me-2"></i>Update Stock
                                                </button></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item text-danger" onclick="confirmDelete({{ $drug->id }}, '{{ $drug->nama_obat }}')">
                                                    <i class="bi bi-trash me-2"></i>Delete Drug
                                                </button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $drugs->firstItem() }} to {{ $drugs->lastItem() }} of {{ $drugs->total() }} results
                        </div>
                        {{ $drugs->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-capsule display-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No drugs found</h5>
                    <p class="text-muted mb-4">
                        @if(request()->has('search') || request()->has('category') || request()->has('stock_status'))
                            Try adjusting your search criteria or <a href="{{ route('drugs.index') }}">clear filters</a>
                        @else
                            Start by adding your first drug to the inventory
                        @endif
                    </p>
                    <a href="{{ route('drugs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add First Drug
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="stockForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Drug Name</label>
                        <input type="text" class="form-control" id="drugName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Stock</label>
                        <input type="number" class="form-control" id="currentStock" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="stockChange" class="form-label">Stock Change</label>
                        <input type="number" class="form-control" id="stockChange" name="stock_change" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="add">Add Stock</option>
                            <option value="subtract">Subtract Stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" required 
                               placeholder="e.g., New delivery, Damaged goods, etc.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Drug</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle display-1 text-warning mb-3"></i>
                    <h5>Are you sure?</h5>
                    <p class="text-muted">This action will permanently delete <strong id="deleteDrugName"></strong> from your inventory.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" id="deleteForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showStockModal(drugId, drugName, currentStock) {
    document.getElementById('stockForm').action = `/drugs/${drugId}/stock`;
    document.getElementById('drugName').value = drugName;
    document.getElementById('currentStock').value = currentStock;
    document.getElementById('stockChange').value = '';
    document.getElementById('reason').value = '';
    new bootstrap.Modal(document.getElementById('stockModal')).show();
}

function confirmDelete(drugId, drugName) {
    document.getElementById('deleteDrugName').textContent = drugName;
    document.getElementById('deleteForm').action = `/drugs/${drugId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function exportToExcel() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Auto-submit search form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const stockStatusSelect = document.getElementById('stock_status');
    
    categorySelect.addEventListener('change', function() {
        this.form.submit();
    });
    
    stockStatusSelect.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush 