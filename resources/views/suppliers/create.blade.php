@extends('layouts.app')

@section('title', 'Add New Supplier')

@push('styles')
<style>
/* Modern Supplier Create Page Styles */
.modern-create-header {
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

.section-container {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.section-header {
    color: #3b82f6;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #334155;
    display: flex;
    align-items: center;
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

.modern-form-control.is-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
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

.modern-btn-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
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

.modern-btn-warning:hover {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    color: white;
    text-decoration: none;
}

.invalid-feedback {
    color: #ef4444 !important;
}

.form-text {
    color: #94a3b8 !important;
}

.required-asterisk {
    color: #ef4444;
}

.form-preview {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.preview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #334155;
}

.preview-item:last-child {
    border-bottom: none;
}

.preview-label {
    color: #94a3b8;
    font-weight: 500;
}

.preview-value {
    color: #f8fafc;
    font-weight: 600;
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header -->
    <div class="modern-create-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Add New Supplier</h2>
                    <p class="mb-0" style="color: #94a3b8;">Create a new supplier profile for your pharmacy</p>
                </div>
            </div>
            <a href="{{ route('admin.suppliers.index') }}" class="modern-btn-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Suppliers
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i>Supplier Information
                    </h5>
                </div>
                <div class="modern-card-body">
                    <form method="POST" action="{{ route('admin.suppliers.store') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="section-container">
                            <h6 class="section-header">
                                <i class="bi bi-info-circle me-2"></i>Basic Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_supplier" class="modern-form-label">Supplier Name <span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control modern-form-control @error('nama_supplier') is-invalid @enderror" 
                                           id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier') }}" 
                                           placeholder="Enter supplier name" required>
                                    @error('nama_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_person" class="modern-form-label">Contact Person <span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control modern-form-control @error('contact_person') is-invalid @enderror" 
                                           id="contact_person" name="contact_person" value="{{ old('contact_person') }}" 
                                           placeholder="Enter contact person name" required>
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="section-container">
                            <h6 class="section-header">
                                <i class="bi bi-geo-alt me-2"></i>Address Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="alamat" class="modern-form-label">Address <span class="required-asterisk">*</span></label>
                                    <textarea class="form-control modern-form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" name="alamat" rows="3" placeholder="Enter complete address" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="kota" class="modern-form-label">City <span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control modern-form-control @error('kota') is-invalid @enderror" 
                                           id="kota" name="kota" value="{{ old('kota') }}" placeholder="Enter city name" required>
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="section-container">
                            <h6 class="section-header">
                                <i class="bi bi-telephone me-2"></i>Contact Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomor_telepon" class="modern-form-label">Phone Number <span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="tel" class="form-control modern-form-control @error('nomor_telepon') is-invalid @enderror" 
                                               id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" 
                                               placeholder="Enter phone number" required>
                                        @error('nomor_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="modern-form-label">Email Address <span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control modern-form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" 
                                               placeholder="Enter email address" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="section-container">
                            <h6 class="section-header">
                                <i class="bi bi-toggle-on me-2"></i>Status
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="status" class="modern-form-label">Supplier Status <span class="required-asterisk">*</span></label>
                                    <select class="form-select modern-form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Set initial status for the supplier</small>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid #334155;">
                            <div>
                                <small style="color: #94a3b8;">
                                    <span class="required-asterisk">*</span> Required fields
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="reset" class="modern-btn-warning">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                </button>
                                <button type="submit" class="modern-btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>Create Supplier
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
                    
                    // Scroll to first invalid field
                    const firstInvalid = form.querySelector('.is-invalid, :invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
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
    
    // Remove invalid state if field becomes valid
    if (value.length > 0) {
        e.target.classList.remove('is-invalid');
    }
});

// Email validation
document.getElementById('email').addEventListener('blur', function(e) {
    const email = e.target.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        e.target.classList.add('is-invalid');
        // Find or create invalid feedback div
        let feedback = e.target.parentNode.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            e.target.parentNode.appendChild(feedback);
        }
        feedback.textContent = 'Please enter a valid email address.';
    } else {
        e.target.classList.remove('is-invalid');
    }
});

// Real-time field validation
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['nama_supplier', 'contact_person', 'alamat', 'kota', 'nomor_telepon', 'email', 'status'];
    
    fields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            });
        }
    });
    
    // Auto-generate supplier code (optional enhancement)
    const nameField = document.getElementById('nama_supplier');
    if (nameField) {
        nameField.addEventListener('input', function() {
            // You can add logic here to auto-generate supplier codes if needed
        });
    }
});

// Form reset confirmation
document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
    if (!confirm('Are you sure you want to reset all fields? This action cannot be undone.')) {
        e.preventDefault();
    } else {
        // Remove validation classes on reset
        setTimeout(() => {
            document.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                el.classList.remove('is-valid', 'is-invalid');
            });
            document.querySelector('.needs-validation').classList.remove('was-validated');
        }, 10);
    }
});
</script>
@endpush 