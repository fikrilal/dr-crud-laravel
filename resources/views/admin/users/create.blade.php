@extends('layouts.app')

@section('title', 'Add New User')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User Management</a></li>
        <li class="breadcrumb-item active">Add New User</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Add New User
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Display any errors or success messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">Create a new admin or pharmacist account. Customer accounts are created through registration.</p>
                    
                    <form method="POST" action="{{ route('admin.users.store') }}" id="userForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_type" class="form-label">User Type *</label>
                                    <select class="form-select @error('user_type') is-invalid @enderror" 
                                            id="user_type" name="user_type" required onchange="toggleCustomerFields()">
                                        <option value="">Select User Type</option>
                                        <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="pharmacist" {{ old('user_type') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                        <option value="customer" {{ old('user_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Admin: Full system access | Pharmacist: Sales and inventory | Customer: Online ordering
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Account Status</label>
                                    <select class="form-select @error('is_active') is-invalid @enderror" 
                                            id="is_active" name="is_active">
                                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password *</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Minimum 8 characters required</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Specific Fields -->
                        <div id="customerFields" class="customer-fields" style="display: none;">
                            <hr class="my-4">
                            <h6 class="mb-3">
                                <i class="bi bi-person-badge me-2"></i>Customer Information
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name *</label>
                                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_phone" class="form-label">Phone Number *</label>
                                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                               id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                                        @error('customer_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_address" class="form-label">Address *</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                          id="customer_address" name="customer_address" rows="3">{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_city" class="form-label">City *</label>
                                        <input type="text" class="form-control @error('customer_city') is-invalid @enderror" 
                                               id="customer_city" name="customer_city" value="{{ old('customer_city') }}">
                                        @error('customer_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_email" class="form-label">Customer Email</label>
                                        <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                               id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                        @error('customer_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Optional - can be different from login email</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="birth_date" class="form-label">Birth Date</label>
                                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                               id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" 
                                                id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Male</option>
                                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Users
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="bi bi-shield-check me-2"></i>Admin Privileges
                            </h6>
                            <ul class="list-unstyled mb-0 small">
                                <li><i class="bi bi-check-circle text-success me-2"></i>Full system administration</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>User management</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>System configuration</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Reports and analytics</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>All sales and inventory features</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-body">
                            <h6 class="card-title text-success">
                                <i class="bi bi-heart-pulse me-2"></i>Pharmacist Privileges
                            </h6>
                            <ul class="list-unstyled mb-0 small">
                                <li><i class="bi bi-check-circle text-success me-2"></i>Process sales transactions</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Manage inventory</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Create purchase orders</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Customer order management</li>
                                <li><i class="bi bi-x-circle text-danger me-2"></i>Cannot manage users</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-body">
                            <h6 class="card-title text-info">
                                <i class="bi bi-person-check me-2"></i>Customer Privileges
                            </h6>
                            <ul class="list-unstyled mb-0 small">
                                <li><i class="bi bi-check-circle text-success me-2"></i>Browse drug catalog online</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Place online orders</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>View order history</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Manage personal profile</li>
                                <li><i class="bi bi-x-circle text-danger me-2"></i>Cannot access admin or sales features</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleCustomerFields() {
    const userType = document.getElementById('user_type').value;
    const customerFields = document.getElementById('customerFields');
    
    console.log('User type changed to:', userType);
    
    if (userType === 'customer') {
        customerFields.style.display = 'block';
        // Make customer fields required
        document.getElementById('customer_name').required = true;
        document.getElementById('customer_phone').required = true;
        document.getElementById('customer_address').required = true;
        document.getElementById('customer_city').required = true;
        console.log('Customer fields are now visible and required');
    } else {
        customerFields.style.display = 'none';
        // Remove required from customer fields and clear their values
        const customerInputs = ['customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_email', 'birth_date', 'gender'];
        customerInputs.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.required = false;
                field.value = ''; // Clear the value to prevent validation issues
            }
        });
        console.log('Customer fields are now hidden, not required, and cleared');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Setting up form handlers');
    
    // Check initial state on page load
    toggleCustomerFields();
    
    // Add form submission handler
    const form = document.getElementById('userForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        console.log('Form found, adding submit event listener');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        // Check CSRF token
        const csrfToken = form.querySelector('input[name="_token"]');
        if (csrfToken) {
            console.log('CSRF token found:', csrfToken.value.substring(0, 10) + '...');
        } else {
            console.error('CSRF token not found!');
            alert('Error: CSRF token missing. Please refresh the page.');
        }
        
        form.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
            console.log('Event type:', e.type);
            console.log('Target:', e.target);
            
            // Prevent double submission
            if (submitBtn.disabled) {
                console.log('Submit button already disabled, preventing double submission');
                e.preventDefault();
                return false;
            }
            
            // Get form data for debugging
            const formData = new FormData(form);
            const formObject = {};
            for (let [key, value] of formData.entries()) {
                if (key === 'password' || key === 'password_confirmation') {
                    formObject[key] = '[HIDDEN]';
                } else {
                    formObject[key] = value;
                }
            }
            
            console.log('Form data being submitted:', formObject);
            
            // Check form validity using HTML5 validation
            if (!form.checkValidity()) {
                console.error('Form validation failed');
                form.reportValidity();
                e.preventDefault();
                return false;
            }
            
            // Check for required fields manually
            const requiredFields = form.querySelectorAll('[required]');
            let missingFields = [];
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    missingFields.push(field.name || field.id);
                }
            });
            
            if (missingFields.length > 0) {
                console.error('Missing required fields:', missingFields);
                alert('Please fill in all required fields: ' + missingFields.join(', '));
                e.preventDefault();
                return false;
            }
            
            // Password confirmation check
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (password !== passwordConfirmation) {
                console.error('Password confirmation does not match');
                alert('Password confirmation does not match. Please check your passwords.');
                e.preventDefault();
                return false;
            }
            
            console.log('All validations passed, submitting form...');
            
            // If not creating a customer, remove customer field names so they're not submitted
            const userType = document.getElementById('user_type').value;
            if (userType !== 'customer') {
                const customerInputs = ['customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_email', 'birth_date', 'gender'];
                customerInputs.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.removeAttribute('name'); // Remove name attribute so field won't be submitted
                        console.log('Removed name attribute from', fieldId);
                    }
                });
                console.log('Removed name attributes from customer fields for non-customer user type');
            }
            
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating User...';
            
            // Monitor form submission
            console.log('Form is being submitted to:', form.action);
            
            // Show loading alert after delay
            setTimeout(() => {
                if (submitBtn.disabled) {
                    console.log('Form submission taking longer than expected - this might indicate an issue');
                    alert('The form is being processed. Please wait...');
                }
            }, 3000);
            
            // Re-enable button after timeout (in case of error)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    console.log('Re-enabling submit button after timeout');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Create User';
                }
            }, 10000);
        });
    } else {
        console.error('Form with ID "userForm" not found!');
        alert('Error: Form not found. Please refresh the page and try again.');
    }
    
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    if (passwordInput && confirmPasswordInput) {
        console.log('Password fields found, adding validation');
        
        // Real-time password confirmation validation
        confirmPasswordInput.addEventListener('input', function() {
            console.log('Password confirmation field changed');
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.classList.add('is-invalid');
                if (!confirmPasswordInput.nextElementSibling || !confirmPasswordInput.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Passwords do not match';
                    confirmPasswordInput.parentNode.appendChild(feedback);
                }
                console.log('Password mismatch detected');
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
                const feedback = confirmPasswordInput.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
                console.log('Passwords match');
            }
        });
    } else {
        console.error('Password fields not found!');
    }
    
    // Debug user type selector
    const userTypeSelect = document.getElementById('user_type');
    if (userTypeSelect) {
        userTypeSelect.addEventListener('change', function() {
            console.log('User type selector changed to:', this.value);
        });
    }
    
    console.log('Form setup completed');
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('JavaScript error occurred:', e.error);
    console.error('Error message:', e.message);
    console.error('File:', e.filename);
    console.error('Line:', e.lineno);
});

// Handle beforeunload to warn about unsaved changes
window.addEventListener('beforeunload', function(e) {
    const form = document.getElementById('userForm');
    if (form) {
        const formData = new FormData(form);
        let hasData = false;
        
        for (let [key, value] of formData.entries()) {
            if (value.trim() && key !== '_token') {
                hasData = true;
                break;
            }
        }
        
        if (hasData) {
            console.log('User trying to leave page with unsaved form data');
        }
    }
});
</script>
@endpush