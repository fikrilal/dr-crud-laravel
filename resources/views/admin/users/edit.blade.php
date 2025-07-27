@extends('layouts.app')

@section('title', 'Edit User')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User Management</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="bi bi-pencil me-2"></i>Edit User: {{ $user->name }}
                        </h5>
                        <small class="text-muted">User ID: {{ $user->id }} | Joined: {{ $user->created_at->format('M d, Y') }}</small>
                    </div>
                    <span class="badge bg-label-{{ $user->user_type == 'admin' ? 'danger' : 'success' }} fs-6">
                        {{ ucfirst($user->user_type) }}
                    </span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
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
                                        <option value="admin" {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="pharmacist" {{ old('user_type', $user->user_type) == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                        <option value="customer" {{ old('user_type', $user->user_type) == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Current: {{ ucfirst($user->user_type) }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Account Status</label>
                                    <select class="form-select @error('is_active') is-invalid @enderror" 
                                            id="is_active" name="is_active"
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @if($user->id === auth()->id())
                                        <input type="hidden" name="is_active" value="1">
                                        <small class="form-text text-muted">You cannot deactivate your own account</small>
                                    @endif
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">
                            <i class="bi bi-key me-2"></i>Change Password (Optional)
                        </h6>
                        <p class="text-muted small mb-3">Leave password fields empty to keep current password</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Minimum 8 characters required</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <!-- Customer Specific Fields -->
                        @if($user->isCustomer())
                        <div id="customerFields" class="customer-fields">
                            <hr class="my-4">
                            <h6 class="mb-3">
                                <i class="bi bi-person-badge me-2"></i>Customer Information
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name *</label>
                                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" name="customer_name" 
                                               value="{{ old('customer_name', $user->customer->nm_pelanggan ?? '') }}" required>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_phone" class="form-label">Phone Number *</label>
                                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                               id="customer_phone" name="customer_phone" 
                                               value="{{ old('customer_phone', $user->customer->telpon ?? '') }}" required>
                                        @error('customer_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_address" class="form-label">Address *</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                          id="customer_address" name="customer_address" rows="3" required>{{ old('customer_address', $user->customer->alamat ?? '') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_city" class="form-label">City *</label>
                                        <input type="text" class="form-control @error('customer_city') is-invalid @enderror" 
                                               id="customer_city" name="customer_city" 
                                               value="{{ old('customer_city', $user->customer->kota ?? '') }}" required>
                                        @error('customer_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_email" class="form-label">Customer Email</label>
                                        <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                               id="customer_email" name="customer_email" 
                                               value="{{ old('customer_email', $user->customer->email ?? '') }}">
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
                                               id="birth_date" name="birth_date" 
                                               value="{{ old('birth_date', $user->customer->tanggal_lahir?->format('Y-m-d') ?? '') }}">
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
                                            <option value="L" {{ old('gender', $user->customer->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Male</option>
                                            <option value="P" {{ old('gender', $user->customer->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
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
                        @endif

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Users
                            </a>
                            <div>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info me-2">
                                    <i class="bi bi-eye me-2"></i>View Details
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Activity Summary -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-activity me-2"></i>User Activity Summary
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-primary fs-4">{{ $user->sales()->count() }}</span>
                                <small class="text-muted">Sales Processed</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-success fs-4">{{ $user->purchases()->count() }}</span>
                                <small class="text-muted">Purchase Orders</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-info fs-4">{{ $user->created_at->diffInDays(now()) }}</span>
                                <small class="text-muted">Days Active</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-warning fs-4">{{ $user->updated_at->diffForHumans() }}</span>
                                <small class="text-muted">Last Activity</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($user->id !== auth()->id())
            <div class="card mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0 text-white">
                        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="text-danger">Delete User Account</h6>
                            <p class="text-muted mb-0">
                                Permanently delete this user account. This action cannot be undone.
                                @php
                                    $hasTransactions = $user->sales()->count() > 0 || $user->purchases()->count() > 0;
                                    $hasCustomerOrders = false;
                                    if ($user->isCustomer() && $user->kd_pelanggan) {
                                        $hasCustomerOrders = \App\Models\Sale::where('kd_pelanggan', $user->kd_pelanggan)
                                            ->where('tipe_transaksi', 'online')
                                            ->count() > 0;
                                    }
                                    $canDelete = !$hasTransactions && !$hasCustomerOrders;
                                @endphp
                                @if($hasTransactions)
                                    <br><strong class="text-warning">Note: This user has transaction history and cannot be deleted.</strong>
                                @endif
                                @if($hasCustomerOrders)
                                    <br><strong class="text-warning">Note: This customer has order history and cannot be deleted.</strong>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($canDelete)
                                <button type="button" class="btn btn-danger" 
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                    <i class="bi bi-trash me-2"></i>Delete User
                                </button>
                            @else
                                <button type="button" class="btn btn-outline-danger" disabled>
                                    <i class="bi bi-shield-x me-2"></i>Cannot Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete User
                    </button>
                </form>
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
    
    if (userType === 'customer') {
        customerFields.style.display = 'block';
        // Make customer fields required
        const nameField = document.getElementById('customer_name');
        const phoneField = document.getElementById('customer_phone');
        const addressField = document.getElementById('customer_address');
        const cityField = document.getElementById('customer_city');
        
        if (nameField) nameField.required = true;
        if (phoneField) phoneField.required = true;
        if (addressField) addressField.required = true;
        if (cityField) cityField.required = true;
    } else {
        customerFields.style.display = 'none';
        // Remove required from customer fields
        const nameField = document.getElementById('customer_name');
        const phoneField = document.getElementById('customer_phone');
        const addressField = document.getElementById('customer_address');
        const cityField = document.getElementById('customer_city');
        
        if (nameField) nameField.required = false;
        if (phoneField) phoneField.required = false;
        if (addressField) addressField.required = false;
        if (cityField) cityField.required = false;
    }
}

function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = `/admin/users/${userId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Check initial state on page load
    toggleCustomerFields();
    
    // Password confirmation validation
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    function validatePasswordMatch() {
        if (passwordInput.value && confirmPasswordInput.value) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.classList.add('is-invalid');
                if (!confirmPasswordInput.nextElementSibling || !confirmPasswordInput.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Passwords do not match';
                    confirmPasswordInput.parentNode.appendChild(feedback);
                }
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
                const feedback = confirmPasswordInput.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            }
        }
    }
    
    confirmPasswordInput.addEventListener('input', validatePasswordMatch);
    passwordInput.addEventListener('input', validatePasswordMatch);
});
</script>
@endpush