@extends('layouts.app')

@section('title', 'Supplier Details')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Supplier Management</a></li>
        <li class="breadcrumb-item active">{{ $supplier->nama_supplier }}</li>
    @endsection
@endsection

@section('content')
<!-- Supplier Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bi bi-truck fs-1 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="card-title mb-2">{{ $supplier->nama_supplier }}</h3>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-light text-dark me-3">{{ $supplier->kd_supplier }}</span>
                                    @if($supplier->status === 'active')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-pause-circle me-1"></i>Inactive
                                        </span>
                                    @endif
                                </div>
                                <p class="card-text mb-0">
                                    <i class="bi bi-person me-2"></i>Contact: {{ $supplier->contact_person }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-light me-2">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <button class="btn btn-outline-light" onclick="confirmDelete('{{ $supplier->kd_supplier }}', '{{ $supplier->nama_supplier }}')">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
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
                    <i class="bi bi-capsule display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['total_drugs'] }}</h5>
                <p class="card-text text-muted">Total Drugs</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-success mb-2">
                    <i class="bi bi-check2-circle display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['active_drugs'] }}</h5>
                <p class="card-text text-muted">Active Drugs</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-info mb-2">
                    <i class="bi bi-bag display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['total_purchases'] }}</h5>
                <p class="card-text text-muted">Purchase Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-warning mb-2">
                    <i class="bi bi-clock-history display-4"></i>
                </div>
                <h5 class="card-title">{{ $stats['recent_purchases']->count() }}</h5>
                <p class="card-text text-muted">Recent Orders</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Supplier Information -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Supplier Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-building me-2"></i>Basic Information
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Supplier Code</label>
                        <div class="fw-bold fs-5 text-primary">{{ $supplier->kd_supplier }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Supplier Name</label>
                        <div class="fw-bold">{{ $supplier->nama_supplier }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Contact Person</label>
                        <div class="fw-bold">{{ $supplier->contact_person }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <div>
                            @if($supplier->status === 'active')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle me-1"></i>Active
                                </span>
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-pause-circle me-1"></i>Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                            <i class="bi bi-geo-alt me-2"></i>Address Information
                        </h6>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label text-muted">Address</label>
                        <div class="fw-bold">{{ $supplier->alamat }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted">City</label>
                        <div class="fw-bold">
                            <i class="bi bi-geo-alt text-primary me-2"></i>{{ $supplier->kota }}
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                            <i class="bi bi-telephone me-2"></i>Contact Information
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Phone Number</label>
                        <div class="fw-bold">
                            <i class="bi bi-telephone text-primary me-2"></i>{{ $supplier->nomor_telepon }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email Address</label>
                        <div class="fw-bold">
                            <i class="bi bi-envelope text-primary me-2"></i>{{ $supplier->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Purchase Orders -->
        @if($stats['recent_purchases']->count() > 0)
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-bag me-2"></i>Recent Purchase Orders
                </h5>
                <a href="#" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>View All
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['recent_purchases'] as $purchase)
                                <tr>
                                    <td><span class="fw-bold text-primary">{{ $purchase->id }}</span></td>
                                    <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $purchase->purchaseDetails->count() }} items</span></td>
                                    <td><span class="fw-bold">${{ number_format($purchase->total_amount, 2) }}</span></td>
                                    <td>
                                        <span class="badge bg-{{ $purchase->status === 'completed' ? 'success' : ($purchase->status === 'pending' ? 'warning' : 'info') }}">
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Supplier
                    </a>
                    
                    <a href="#" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>New Purchase Order
                    </a>
                    
                    <a href="#" class="btn btn-outline-info">
                        <i class="bi bi-capsule me-2"></i>View Drugs
                    </a>
                    
                    <a href="#" class="btn btn-outline-warning">
                        <i class="bi bi-graph-up me-2"></i>Performance Report
                    </a>
                    
                    <hr class="my-2">
                    
                    <button class="btn btn-outline-danger" onclick="confirmDelete('{{ $supplier->kd_supplier }}', '{{ $supplier->nama_supplier }}')">
                        <i class="bi bi-trash me-2"></i>Delete Supplier
                    </button>
                </div>
            </div>
        </div>

        <!-- Supplier Timeline -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>Timeline
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Supplier Created</h6>
                            <small class="text-muted">{{ $supplier->created_at->format('M d, Y H:i A') }}</small>
                        </div>
                    </div>
                    
                    @if($supplier->updated_at != $supplier->created_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Last Updated</h6>
                            <small class="text-muted">{{ $supplier->updated_at->format('M d, Y H:i A') }}</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($stats['total_drugs'] > 0)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">{{ $stats['total_drugs'] }} Drugs Added</h6>
                            <small class="text-muted">From this supplier</small>
                        </div>
                    </div>
                    @endif
                </div>
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

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -13px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #dee2e6;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -19px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    padding-left: 15px;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(supplierId, supplierName) {
    document.getElementById('supplierName').textContent = supplierName;
    document.getElementById('deleteForm').action = `/admin/suppliers/${supplierId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush 