@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('customer.catalog.index') }}">Catalog</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $drug->nm_obat }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Details -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <!-- Header -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h3 class="mb-2">{{ $drug->nm_obat }}</h3>
                            <div class="mb-3">
                                <span class="badge bg-label-primary me-2">{{ ucfirst($drug->jenis) }}</span>
                                <span class="badge bg-label-secondary me-2">{{ $drug->satuan }}</span>
                                <span class="badge bg-label-{{ $drug->isLowStock() ? 'warning' : 'success' }}">
                                    {{ $drug->stok }} in stock
                                </span>
                                @if($drug->isLowStock())
                                    <span class="badge bg-label-warning">Low Stock</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <h2 class="text-primary mb-0">
                                Rp {{ number_format($drug->harga_jual, 0, ',', '.') }}
                            </h2>
                            <small class="text-muted">per {{ $drug->satuan }}</small>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($drug->description)
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p class="text-muted">{{ $drug->description }}</p>
                        </div>
                    @endif

                    <!-- Product Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Product Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-medium">Drug Code:</td>
                                    <td>{{ $drug->kd_obat }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Category:</td>
                                    <td>{{ ucfirst($drug->jenis) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Form:</td>
                                    <td>{{ $drug->satuan }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Status:</td>
                                    <td>
                                        <span class="badge bg-label-success">{{ ucfirst($drug->status) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Supplier Information</h5>
                            @if($drug->supplier)
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-medium">Supplier:</td>
                                        <td>{{ $drug->supplier->nm_supplier }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">City:</td>
                                        <td>{{ $drug->supplier->kota ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Phone:</td>
                                        <td>{{ $drug->supplier->telpon ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-muted">No supplier information available</p>
                            @endif
                        </div>
                    </div>

                    <!-- Availability Notice -->
                    <div class="alert alert-info" role="alert">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Note:</strong> To purchase this medication, please visit our pharmacy or contact us directly. 
                        Online ordering for medications requires consultation with our licensed pharmacists.
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="contactPharmacy()">
                            <i class="bx bx-phone me-2"></i>Contact Pharmacy
                        </button>
                        <button class="btn btn-outline-primary" onclick="checkAvailability()">
                            <i class="bx bx-check-circle me-2"></i>Check Availability
                        </button>
                        <a href="{{ route('customer.catalog.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-2"></i>Back to Catalog
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stock Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Availability</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="bx bx-package fs-3 text-{{ $drug->isLowStock() ? 'warning' : 'success' }}"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $drug->stok }} units available</h6>
                            <small class="text-muted">
                                @if($drug->isLowStock())
                                    Low stock - Order soon
                                @else
                                    In stock and ready
                                @endif
                            </small>
                        </div>
                    </div>
                    
                    @if($drug->min_stock_level)
                        <div class="progress mb-2" style="height: 6px;">
                            <div class="progress-bar bg-{{ $drug->isLowStock() ? 'warning' : 'success' }}" 
                                 style="width: {{ min(100, ($drug->stok / ($drug->min_stock_level * 3)) * 100) }}%"></div>
                        </div>
                        <small class="text-muted">Minimum stock level: {{ $drug->min_stock_level }}</small>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Need Help?</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Have questions about this medication? Our licensed pharmacists are here to help.
                    </p>
                    <div class="mb-3">
                        <i class="bx bx-phone text-primary me-2"></i>
                        <span>Call us: (555) 123-4567</span>
                    </div>
                    <div class="mb-3">
                        <i class="bx bx-envelope text-primary me-2"></i>
                        <span>Email: pharmacy@drcroud.com</span>
                    </div>
                    <div>
                        <i class="bx bx-time text-primary me-2"></i>
                        <span>Mon-Fri: 8AM-8PM, Sat-Sun: 9AM-6PM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedDrugs->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-4">Related Products</h4>
                <div class="row">
                    @foreach($relatedDrugs as $relatedDrug)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <!-- Stock Badge -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-label-{{ $relatedDrug->isLowStock() ? 'warning' : 'success' }}">
                                            {{ $relatedDrug->stok }} in stock
                                        </span>
                                    </div>

                                    <!-- Drug Name -->
                                    <h6 class="card-title mb-2">
                                        <a href="{{ route('customer.catalog.show', $relatedDrug->kd_obat) }}" 
                                           class="text-decoration-none">
                                            {{ $relatedDrug->nm_obat }}
                                        </a>
                                    </h6>

                                    <!-- Category -->
                                    <div class="mb-2">
                                        <span class="badge bg-label-primary">{{ ucfirst($relatedDrug->jenis) }}</span>
                                        <span class="badge bg-label-secondary">{{ $relatedDrug->satuan }}</span>
                                    </div>

                                    <!-- Price and Action -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-primary">
                                            Rp {{ number_format($relatedDrug->harga_jual, 0, ',', '.') }}
                                        </h6>
                                        <a href="{{ route('customer.catalog.show', $relatedDrug->kd_obat) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function contactPharmacy() {
    alert('Please call us at (555) 123-4567 or visit our pharmacy for assistance with medication orders.');
}

function checkAvailability() {
    alert('This medication is currently in stock with {{ $drug->stok }} units available. Visit our pharmacy for purchase.');
}
</script>
@endsection