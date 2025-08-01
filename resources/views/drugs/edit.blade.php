@extends('layouts.app')

@section('title', 'Edit Drug')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('drugs.index') }}">Drug Management</a></li>
        <li class="breadcrumb-item active">Edit Drug</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Edit Drug</h4>
                    <p class="text-muted mb-0">Update drug information: {{ $drug->nama_obat }}</p>
                </div>
                <a href="{{ route('drugs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>

            <!-- Form Card -->
            <form method="POST" action="{{ route('drugs.update', $drug) }}" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i>Update Drug Information
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
                                <label for="nama_obat" class="form-label">Drug Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" 
                                       id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $drug->nama_obat) }}" required>
                                @error('nama_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kategori" class="form-label">Category <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kategori') is-invalid @enderror" 
                                       id="kategori" name="kategori" value="{{ old('kategori', $drug->kategori) }}" required>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="bentuk_obat" class="form-label">Drug Form <span class="text-danger">*</span></label>
                                <select class="form-select @error('bentuk_obat') is-invalid @enderror" 
                                        id="bentuk_obat" name="bentuk_obat" required>
                                    <option value="">Select Drug Form</option>
                                    @foreach(['Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream', 'Ointment', 'Drops', 'Powder'] as $form)
                                        <option value="{{ $form }}" {{ old('bentuk_obat', $drug->bentuk_obat) == $form ? 'selected' : '' }}>{{ $form }}</option>
                                    @endforeach
                                </select>
                                @error('bentuk_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                                <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                        id="supplier_id" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->kd_supplier }}" {{ old('supplier_id', $drug->supplier_id) == $supplier->kd_supplier ? 'selected' : '' }}>
                                            {{ $supplier->nama_supplier }} ({{ $supplier->kd_supplier }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pricing & Stock -->
                            <div class="col-12 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="bi bi-currency-dollar me-2"></i>Pricing & Stock
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_beli" class="form-label">Buying Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                                           id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $drug->harga_beli) }}" 
                                           step="0.01" min="0" required>
                                    @error('harga_beli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_jual" class="form-label">Selling Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                                           id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $drug->harga_jual) }}" 
                                           step="0.01" min="0" required>
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="stok" class="form-label">Current Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" name="stok" value="{{ old('stok', $drug->stok) }}" min="0" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Use the stock update feature for detailed stock changes</div>
                            </div>

                            <div class="col-md-6">
                                <label for="stok_minimum" class="form-label">Minimum Stock Alert <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stok_minimum') is-invalid @enderror" 
                                       id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', $drug->stok_minimum) }}" min="0" required>
                                @error('stok_minimum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Expiry & Status -->
                            <div class="col-12 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="bi bi-calendar-check me-2"></i>Expiry & Status
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_kadaluarsa" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" 
                                       id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" 
                                       value="{{ old('tanggal_kadaluarsa', $drug->tanggal_kadaluarsa ? $drug->tanggal_kadaluarsa->format('Y-m-d') : '') }}" required>
                                @error('tanggal_kadaluarsa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status', $drug->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $drug->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Medical Information -->
                            <div class="col-12 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="bi bi-heart-pulse me-2"></i>Medical Information
                                </h6>
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $drug->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dosis_dewasa" class="form-label">Adult Dosage</label>
                                <input type="text" class="form-control @error('dosis_dewasa') is-invalid @enderror" 
                                       id="dosis_dewasa" name="dosis_dewasa" value="{{ old('dosis_dewasa', $drug->dosis_dewasa) }}">
                                @error('dosis_dewasa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dosis_anak" class="form-label">Child Dosage</label>
                                <input type="text" class="form-control @error('dosis_anak') is-invalid @enderror" 
                                       id="dosis_anak" name="dosis_anak" value="{{ old('dosis_anak', $drug->dosis_anak) }}">
                                @error('dosis_anak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="efek_samping" class="form-label">Side Effects</label>
                                <textarea class="form-control @error('efek_samping') is-invalid @enderror" 
                                          id="efek_samping" name="efek_samping" rows="3">{{ old('efek_samping', $drug->efek_samping) }}</textarea>
                                @error('efek_samping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kontraindikasi" class="form-label">Contraindications</label>
                                <textarea class="form-control @error('kontraindikasi') is-invalid @enderror" 
                                          id="kontraindikasi" name="kontraindikasi" rows="3">{{ old('kontraindikasi', $drug->kontraindikasi) }}</textarea>
                                @error('kontraindikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('drugs.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('drugs.show', $drug) }}" class="btn btn-outline-info">
                                    <i class="bi bi-eye me-2"></i>View Details
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Drug
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buyingPriceInput = document.getElementById('harga_beli');
    const sellingPriceInput = document.getElementById('harga_jual');
    const stockInput = document.getElementById('stok');
    const minStockInput = document.getElementById('stok_minimum');

    // Price validation
    function validatePrices() {
        const buyingPrice = parseFloat(buyingPriceInput.value) || 0;
        const sellingPrice = parseFloat(sellingPriceInput.value) || 0;

        if (buyingPrice > 0 && sellingPrice > 0 && sellingPrice <= buyingPrice) {
            sellingPriceInput.classList.add('is-invalid');
            return false;
        } else {
            sellingPriceInput.classList.remove('is-invalid');
            return true;
        }
    }

    // Stock validation
    function validateStock() {
        const stock = parseInt(stockInput.value) || 0;
        const minStock = parseInt(minStockInput.value) || 0;

        if (stock > 0 && minStock > stock) {
            minStockInput.classList.add('is-invalid');
            return false;
        } else {
            minStockInput.classList.remove('is-invalid');
            return true;
        }
    }

    buyingPriceInput.addEventListener('input', validatePrices);
    sellingPriceInput.addEventListener('input', validatePrices);
    stockInput.addEventListener('input', validateStock);
    minStockInput.addEventListener('input', validateStock);

    // Form validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validatePrices() || !validateStock()) {
            e.preventDefault();
            alert('Please fix the validation errors before submitting.');
        }
    });

    // Bootstrap form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
@endpush 