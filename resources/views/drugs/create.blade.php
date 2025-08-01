@extends('layouts.app')

@section('title', 'Add New Drug')

@push('styles')
<style>
/* Modern Add Drug Form Styles */
.modern-form-header {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #e2e8f0;
}

.modern-form-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.modern-form-section {
    background: #0f172a;
    border-bottom: 1px solid #334155;
    padding: 1.5rem;
    color: #f8fafc;
}

.modern-form-body {
    padding: 2rem;
}

.modern-form-footer {
    background: #0f172a;
    border-top: 1px solid #334155;
    padding: 1.5rem 2rem;
}

.section-divider {
    display: flex;
    align-items: center;
    margin: 2rem 0 1.5rem;
    color: #3b82f6;
    font-weight: 600;
}

.section-divider::before,
.section-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, #3b82f6, transparent);
}

.section-divider::before {
    margin-right: 1rem;
}

.section-divider::after {
    margin-left: 1rem;
}

.section-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.modern-form-control {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
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

.modern-form-label {
    color: #f8fafc;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.required-asterisk {
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-text-modern {
    color: #94a3b8;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
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
}

.form-select option {
    background: #334155 !important;
    color: #e2e8f0 !important;
}

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

.invalid-feedback {
    color: #f87171 !important;
}

.is-invalid {
    border-color: #ef4444 !important;
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
    color: white;
}

.modern-btn-outline {
    background: transparent;
    border: 1px solid #475569;
    color: #e2e8f0;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.modern-btn-outline:hover {
    background: #334155;
    border-color: #3b82f6;
    color: #e2e8f0;
    text-decoration: none;
}

.pricing-preview {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.profit-margin {
    color: #10b981;
    font-weight: 600;
}

</style>
@endpush

@section('content')
<div class="p-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Modern Header -->
            <div class="modern-form-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-2 fw-bold" style="color: #f8fafc;">Add New Drug</h2>
                        <p class="mb-0" style="color: #94a3b8;">Enter comprehensive drug information to add to inventory</p>
                    </div>
                    <a href="{{ route('drugs.index') }}" class="modern-btn-outline">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>


            <!-- Form Card -->
            <form method="POST" action="{{ route('drugs.store') }}" class="needs-validation" novalidate>
                @csrf
                <div class="modern-form-card">
                    <div class="modern-form-section">
                        <div class="d-flex align-items-center">
                            <div class="section-icon">
                                <i class="bi bi-capsule-pill"></i>
                            </div>
                            <h5 class="mb-0">Drug Information</h5>
                        </div>
                    </div>
                    <div class="modern-form-body">
                        <!-- Basic Information Section -->
                        <div class="section-divider">
                            <div class="section-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            Basic Information
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nama_obat" class="modern-form-label">Drug Name<span class="required-asterisk">*</span></label>
                                <input type="text" class="form-control modern-form-control @error('nama_obat') is-invalid @enderror" 
                                       id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}" required
                                       placeholder="Enter drug name">
                                @error('nama_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kategori" class="modern-form-label">Category<span class="required-asterisk">*</span></label>
                                <input type="text" class="form-control modern-form-control @error('kategori') is-invalid @enderror" 
                                       id="kategori" name="kategori" value="{{ old('kategori') }}" required
                                       placeholder="e.g., Antibiotics, Pain Relief, Vitamins">
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="bentuk_obat" class="modern-form-label">Drug Form<span class="required-asterisk">*</span></label>
                                <select class="form-select @error('bentuk_obat') is-invalid @enderror" 
                                        id="bentuk_obat" name="bentuk_obat" required>
                                    <option value="">Select Drug Form</option>
                                    <option value="Tablet" {{ old('bentuk_obat') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                    <option value="Capsule" {{ old('bentuk_obat') == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                                    <option value="Syrup" {{ old('bentuk_obat') == 'Syrup' ? 'selected' : '' }}>Syrup</option>
                                    <option value="Injection" {{ old('bentuk_obat') == 'Injection' ? 'selected' : '' }}>Injection</option>
                                    <option value="Cream" {{ old('bentuk_obat') == 'Cream' ? 'selected' : '' }}>Cream</option>
                                    <option value="Ointment" {{ old('bentuk_obat') == 'Ointment' ? 'selected' : '' }}>Ointment</option>
                                    <option value="Drops" {{ old('bentuk_obat') == 'Drops' ? 'selected' : '' }}>Drops</option>
                                    <option value="Powder" {{ old('bentuk_obat') == 'Powder' ? 'selected' : '' }}>Powder</option>
                                </select>
                                @error('bentuk_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="supplier_id" class="modern-form-label">Supplier<span class="required-asterisk">*</span></label>
                                <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                        id="supplier_id" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->kd_supplier }}" {{ old('supplier_id') == $supplier->kd_supplier ? 'selected' : '' }}>
                                            {{ $supplier->nama_supplier }} ({{ $supplier->kd_supplier }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pricing & Stock Section -->
                        <div class="section-divider">
                            <div class="section-icon">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            Pricing & Stock
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="harga_beli" class="modern-form-label">Buying Price<span class="required-asterisk">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                                           id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" 
                                           min="1" required placeholder="0">
                                    @error('harga_beli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_jual" class="modern-form-label">Selling Price<span class="required-asterisk">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                                           id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" 
                                           min="1" required placeholder="0">
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="invalid-feedback" id="price-comparison-error" style="display: none;">
                                        Selling price must be greater than buying price
                                    </div>
                                </div>
                                <div id="profit-preview" class="pricing-preview" style="display: none;">
                                    <div class="d-flex justify-content-between">
                                        <span style="color: #94a3b8;">Profit Margin:</span>
                                        <span class="profit-margin" id="profit-amount">-</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="stok" class="modern-form-label">Initial Stock<span class="required-asterisk">*</span></label>
                                <input type="number" class="form-control modern-form-control @error('stok') is-invalid @enderror" 
                                       id="stok" name="stok" value="{{ old('stok') }}" min="1" required placeholder="1">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="stok_minimum" class="modern-form-label">Minimum Stock Alert<span class="required-asterisk">*</span></label>
                                <input type="number" class="form-control modern-form-control @error('stok_minimum') is-invalid @enderror" 
                                       id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum') }}" min="1" required placeholder="1">
                                @error('stok_minimum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text-modern">System will alert when stock falls below this level</div>
                            </div>
                        </div>

                        <!-- Expiry & Status Section -->
                        <div class="section-divider">
                            <div class="section-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            Expiry & Status
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="tanggal_kadaluarsa" class="modern-form-label">Expiry Date</label>
                                <input type="date" class="form-control modern-form-control @error('tanggal_kadaluarsa') is-invalid @enderror" 
                                       id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}">
                                @error('tanggal_kadaluarsa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="modern-form-label">Status<span class="required-asterisk">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Medical Information Section -->
                        <div class="section-divider">
                            <div class="section-icon">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                            Medical Information
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="deskripsi" class="modern-form-label">Description</label>
                                <textarea class="form-control modern-form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3" 
                                          placeholder="Brief description of the drug and its uses">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dosis_dewasa" class="modern-form-label">Adult Dosage</label>
                                <input type="text" class="form-control modern-form-control @error('dosis_dewasa') is-invalid @enderror" 
                                       id="dosis_dewasa" name="dosis_dewasa" value="{{ old('dosis_dewasa') }}"
                                       placeholder="e.g., 1 tablet twice daily">
                                @error('dosis_dewasa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dosis_anak" class="modern-form-label">Child Dosage</label>
                                <input type="text" class="form-control modern-form-control @error('dosis_anak') is-invalid @enderror" 
                                       id="dosis_anak" name="dosis_anak" value="{{ old('dosis_anak') }}"
                                       placeholder="e.g., Half tablet twice daily">
                                @error('dosis_anak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="efek_samping" class="modern-form-label">Side Effects</label>
                                <textarea class="form-control modern-form-control @error('efek_samping') is-invalid @enderror" 
                                          id="efek_samping" name="efek_samping" rows="3"
                                          placeholder="List common side effects">{{ old('efek_samping') }}</textarea>
                                @error('efek_samping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kontraindikasi" class="modern-form-label">Contraindications</label>
                                <textarea class="form-control modern-form-control @error('kontraindikasi') is-invalid @enderror" 
                                          id="kontraindikasi" name="kontraindikasi" rows="3"
                                          placeholder="When this drug should not be used">{{ old('kontraindikasi') }}</textarea>
                                @error('kontraindikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modern-form-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('drugs.index') }}" class="modern-btn-outline">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="modern-btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Add Drug
                            </button>
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
    const expiryDateInput = document.getElementById('tanggal_kadaluarsa');

    // Set minimum expiry date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    expiryDateInput.min = tomorrow.toISOString().split('T')[0];

    // Price validation
    function validatePrices() {
        const buyingPrice = parseFloat(buyingPriceInput.value) || 0;
        const sellingPrice = parseFloat(sellingPriceInput.value) || 0;
        const errorDiv = document.getElementById('price-comparison-error');

        if (buyingPrice > 0 && sellingPrice > 0 && sellingPrice <= buyingPrice) {
            sellingPriceInput.classList.add('is-invalid');
            errorDiv.style.display = 'block';
            return false;
        } else {
            sellingPriceInput.classList.remove('is-invalid');
            errorDiv.style.display = 'none';
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

    // Auto-calculate suggested selling price (30% markup)
    buyingPriceInput.addEventListener('input', function() {
        const buyingPrice = parseFloat(this.value) || 0;
        if (buyingPrice > 0 && !sellingPriceInput.value) {
            const suggestedPrice = (buyingPrice * 1.3).toFixed(2);
            sellingPriceInput.value = suggestedPrice;
        }
        validatePrices();
    });

    sellingPriceInput.addEventListener('input', validatePrices);
    stockInput.addEventListener('input', validateStock);
    minStockInput.addEventListener('input', validateStock);

    // Test submit button click - be more specific
    const submitButton = document.querySelector('.modern-form-footer button[type="submit"]');
    console.log('Drug form submit button found:', submitButton);
    console.log('Submit button disabled:', submitButton ? submitButton.disabled : 'button not found');
    console.log('Submit button style display:', submitButton ? getComputedStyle(submitButton).display : 'button not found');
    console.log('Submit button pointer events:', submitButton ? getComputedStyle(submitButton).pointerEvents : 'button not found');
    
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            console.log('Submit button clicked');
            console.log('Event default prevented?', e.defaultPrevented);
            console.log('Button disabled at click time:', this.disabled);
        });
        
        // Test if button responds to hover
        submitButton.addEventListener('mouseenter', function() {
            console.log('Submit button hovered');
        });
        
        // Test if button responds to mouse down
        submitButton.addEventListener('mousedown', function() {
            console.log('Submit button mouse down');
        });
    } else {
        console.error('Submit button not found!');
    }

    // Form validation before submit - be more specific
    const form = document.querySelector('form[action*="drugs.store"], form.needs-validation');
    console.log('Drug creation form found:', form);
    console.log('Form action:', form ? form.action : 'form not found');
    console.log('Form novalidate attribute:', form ? form.noValidate : 'form not found');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission triggered');
            let isValid = true;
            
            // Check custom validations
            if (!validatePrices()) {
                console.log('Price validation failed');
                isValid = false;
            }
            if (!validateStock()) {
                console.log('Stock validation failed');
                isValid = false;
            }
            
            // Check HTML5 form validation
            if (!this.checkValidity()) {
                console.log('HTML5 validation failed');
                
                // Show which fields are invalid
                const invalidFields = this.querySelectorAll(':invalid');
                console.log('Invalid fields:', invalidFields);
                invalidFields.forEach(field => {
                    console.log('Invalid field:', field.name || field.id, 'Value:', field.value, 'Required:', field.required);
                    console.log('  - Valid state:', field.validity);
                    console.log('  - Validation message:', field.validationMessage);
                });
                
                isValid = false;
                this.classList.add('was-validated');
            }
            
            if (!isValid) {
                console.log('Form validation failed, preventing submission');
                e.preventDefault();
                e.stopPropagation();
                alert('Please fix the validation errors before submitting.');
            } else {
                console.log('Form validation passed, submitting...');
            }
        });
    } else {
        console.error('Form not found!');
    }
});
</script>
@endpush 