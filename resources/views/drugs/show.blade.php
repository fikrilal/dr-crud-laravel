@extends('layouts.app')

@section('title', 'Drug Details')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('drugs.index') }}">Drug Management</a></li>
        <li class="breadcrumb-item active">Drug Details</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">{{ $drug->nama_obat }}</h4>
                    <p class="text-muted mb-0">Complete drug information and details</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('drugs.edit', $drug) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil-square me-2"></i>Edit Drug
                    </a>
                    <a href="{{ route('drugs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Main Drug Information -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-capsule-pill me-2"></i>Drug Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Basic Information -->
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="bi bi-info-circle me-2"></i>Basic Information
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Drug Name</label>
                                    <div class="fw-bold">{{ $drug->nama_obat }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Category</label>
                                    <div>
                                        <span class="badge bg-light text-dark fs-6">{{ $drug->kategori }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Drug Form</label>
                                    <div class="fw-bold">{{ $drug->bentuk_obat }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Supplier</label>
                                    <div>
                                        @if($drug->supplier)
                                            <span class="badge bg-primary">{{ $drug->supplier->nama_supplier }}</span>
                                        @else
                                            <span class="text-danger">No Supplier Assigned</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Pricing & Stock -->
                                <div class="col-12 mt-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="bi bi-currency-dollar me-2"></i>Pricing & Stock
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Buying Price</label>
                                    <div class="fw-bold text-success fs-5">${{ number_format($drug->harga_beli, 2) }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Selling Price</label>
                                    <div class="fw-bold text-primary fs-5">${{ number_format($drug->harga_jual, 2) }}</div>
                                    @php
                                        $margin = $drug->harga_beli > 0 ? (($drug->harga_jual - $drug->harga_beli) / $drug->harga_beli) * 100 : 0;
                                    @endphp
                                    <small class="text-muted">Margin: {{ number_format($margin, 1) }}%</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Current Stock</label>
                                    <div class="d-flex align-items-center">
                                        @if($drug->stok <= 0)
                                            <span class="badge bg-danger fs-6">Out of Stock</span>
                                        @elseif($drug->stok <= $drug->stok_minimum)
                                            <span class="badge bg-warning fs-6">{{ $drug->stok }} units (Low Stock)</span>
                                        @else
                                            <span class="badge bg-success fs-6">{{ $drug->stok }} units</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Minimum Stock Alert</label>
                                    <div class="fw-bold">{{ $drug->stok_minimum }} units</div>
                                </div>

                                <!-- Expiry & Status -->
                                <div class="col-12 mt-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="bi bi-calendar-check me-2"></i>Expiry & Status
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Expiry Date</label>
                                    <div>
                                        @php
                                            $expiryDate = \Carbon\Carbon::parse($drug->tanggal_kadaluarsa);
                                            $daysToExpiry = $expiryDate->diffInDays(now());
                                        @endphp
                                        <div class="fw-bold">{{ $expiryDate->format('F d, Y') }}</div>
                                        @if($expiryDate->isPast())
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($daysToExpiry <= 30)
                                            <span class="badge bg-warning">Expiring in {{ $daysToExpiry }} days</span>
                                        @elseif($daysToExpiry <= 90)
                                            <span class="badge bg-info">{{ $daysToExpiry }} days remaining</span>
                                        @else
                                            <span class="badge bg-success">{{ $daysToExpiry }} days remaining</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Status</label>
                                    <div>
                                        @if($drug->status === 'active')
                                            <span class="badge bg-success fs-6">Active</span>
                                        @else
                                            <span class="badge bg-secondary fs-6">Inactive</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($drug->deskripsi)
                                    <div class="col-12 mt-4">
                                        <h6 class="text-primary border-bottom pb-2 mb-3">
                                            <i class="bi bi-file-text me-2"></i>Description
                                        </h6>
                                        <p class="mb-0">{{ $drug->deskripsi }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" onclick="showStockModal({{ $drug->id }}, '{{ $drug->nama_obat }}', {{ $drug->stok }})">
                                    <i class="bi bi-box me-2"></i>Update Stock
                                </button>
                                <a href="{{ route('drugs.edit', $drug) }}" class="btn btn-outline-success">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Drug
                                </a>
                                <button class="btn btn-outline-danger" onclick="confirmDelete({{ $drug->id }}, '{{ $drug->nama_obat }}')">
                                    <i class="bi bi-trash me-2"></i>Delete Drug
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information -->
                    @if($drug->dosis_dewasa || $drug->dosis_anak || $drug->efek_samping || $drug->kontraindikasi)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-heart-pulse me-2"></i>Medical Information
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($drug->dosis_dewasa)
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Adult Dosage</label>
                                        <div class="fw-bold">{{ $drug->dosis_dewasa }}</div>
                                    </div>
                                @endif

                                @if($drug->dosis_anak)
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Child Dosage</label>
                                        <div class="fw-bold">{{ $drug->dosis_anak }}</div>
                                    </div>
                                @endif

                                @if($drug->efek_samping)
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Side Effects</label>
                                        <div class="small">{{ $drug->efek_samping }}</div>
                                    </div>
                                @endif

                                @if($drug->kontraindikasi)
                                    <div class="mb-0">
                                        <label class="form-label text-muted small">Contraindications</label>
                                        <div class="small text-danger">{{ $drug->kontraindikasi }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
</script>
@endpush 