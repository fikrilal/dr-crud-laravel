@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Supplier Management</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.show', $supplier) }}">{{ $supplier->nama_supplier }}</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endsection
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>Edit Supplier: {{ $supplier->nama_supplier }}
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <!-- Supplier Code (Read-only) -->
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-hash me-2"></i>Supplier Code
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="kd_supplier" class="form-label">Supplier Code</label>
                                <input type="text" class="form-control" id="kd_supplier" value="{{ $supplier->kd_supplier }}" readonly>
                                <div class="form-text">Supplier code cannot be changed.</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-info-circle me-2"></i>Basic Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_supplier" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" 
                                       id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                                @error('nama_supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_person" class="form-label">Contact Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" required>
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-geo-alt me-2"></i>Address Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="alamat" class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" name="alamat" rows="3" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="kota" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                                       id="kota" name="kota" value="{{ old('kota', $supplier->kota) }}" required>
                                @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-telephone me-2"></i>Contact Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nomor_telepon" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="tel" class="form-control @error('nomor_telepon') is-invalid @enderror" 
                                           id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $supplier->nomor_telepon) }}" required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $supplier->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-toggle-on me-2"></i>Status
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Supplier Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status', $supplier->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $supplier->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Details
                                </a>
                                <div>
                                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-info me-2">
                                        <i class="bi bi-list me-2"></i>All Suppliers
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-2"></i>Update Supplier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Format phone number as user types
document.getElementById('nomor_telepon').addEventListener('input', function(e) {
    // Remove all non-digit characters
    let value = e.target.value.replace(/\D/g, '');
    
    // Limit to reasonable phone number length
    if (value.length > 15) {
        value = value.slice(0, 15);
    }
    
    e.target.value = value;
});

// Email validation
document.getElementById('email').addEventListener('blur', function(e) {
    const email = e.target.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        e.target.classList.add('is-invalid');
        e.target.nextElementSibling.textContent = 'Please enter a valid email address.';
    } else {
        e.target.classList.remove('is-invalid');
    }
});
</script>
@endpush 