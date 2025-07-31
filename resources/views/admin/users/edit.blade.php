@extends('layouts.app')

@section('title', 'Edit User')

@push('styles')
<style>
/* Modern User Edit Page Styles */
.modern-edit-header {
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

.form-select.modern-form-control:disabled {
    background: #1e293b !important;
    color: #64748b !important;
    opacity: 0.7;
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

.modern-btn-outline-info {
    background: transparent;
    border: 1px solid #06b6d4;
    color: #06b6d4;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.modern-btn-outline-info:hover {
    background: #06b6d4;
    color: white;
    text-decoration: none;
}

.modern-btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
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

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-outline-danger {
    background: transparent;
    border: 1px solid #ef4444;
    color: #ef4444;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.modern-btn-outline-danger:hover {
    background: #ef4444;
    color: white;
    text-decoration: none;
}

.modern-btn-outline-danger:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.modern-btn-outline-danger:disabled:hover {
    background: transparent;
    color: #ef4444;
    transform: none;
}

.modern-badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
}

.modern-badge.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    color: white !important;
}

.modern-badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white !important;
}

.modern-badge.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    color: white !important;
}

.stats-card {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    color: #e2e8f0;
    transition: all 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.stats-value {
    font-size: 2rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #cbd5e1;
    font-size: 0.875rem;
}

.invalid-feedback {
    color: #ef4444 !important;
}

.form-text {
    color: #94a3b8 !important;
}

.danger-zone-card {
    background: #1e293b;
    border: 1px solid #ef4444 !important;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

.danger-zone-header {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-bottom: 1px solid #dc2626;
    padding: 1.5rem;
    color: white;
    border-radius: 16px 16px 0 0;
}

.danger-zone-body {
    padding: 1.5rem;
    color: #e2e8f0;
}

.customer-fields-section {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.section-divider {
    border: none;
    height: 1px;
    background: linear-gradient(90deg, transparent, #334155, transparent);
    margin: 2rem 0;
}

/* Modern Modal Styles */
.modal-content {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 16px;
}

.modal-header {
    background: #0f172a;
    border-bottom: 1px solid #334155 !important;
    color: #f8fafc;
    border-radius: 16px 16px 0 0;
}

.modal-body {
    background: #1e293b;
    color: #e2e8f0;
}

.modal-footer {
    background: #1e293b;
    border-top: 1px solid #334155 !important;
    border-radius: 0 0 16px 16px;
}

.btn-close {
    filter: invert(1);
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header -->
    <div class="modern-edit-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Edit User: {{ $user->name }}</h2>
                    <p class="mb-0" style="color: #94a3b8;">User ID: {{ $user->id }} • Joined: {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @php
                    $typeClass = match($user->user_type) {
                        'admin' => 'bg-danger',
                        'pharmacist' => 'bg-success',
                        'customer' => 'bg-info',
                        default => 'bg-secondary'
                    };
                @endphp
                <span class="modern-badge {{ $typeClass }}">
                    {{ ucfirst($user->user_type) }}
                </span>
                <a href="{{ route('admin.users.index') }}" class="modern-btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>Back to Users
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-gear me-2"></i>User Information
                    </h5>
                </div>
                <div class="modern-card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="modern-form-label">Full Name *</label>
                                    <input type="text" class="form-control modern-form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="modern-form-label">Email Address *</label>
                                    <input type="email" class="form-control modern-form-control @error('email') is-invalid @enderror" 
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
                                    <label for="user_type" class="modern-form-label">User Type *</label>
                                    <select class="form-select modern-form-control @error('user_type') is-invalid @enderror" 
                                            id="user_type" name="user_type" required onchange="toggleCustomerFields()">
                                        <option value="">Select User Type</option>
                                        <option value="admin" {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="pharmacist" {{ old('user_type', $user->user_type) == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                        <option value="customer" {{ old('user_type', $user->user_type) == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">
                                        Current: {{ ucfirst($user->user_type) }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="modern-form-label">Account Status</label>
                                    <select class="form-select modern-form-control @error('is_active') is-invalid @enderror" 
                                            id="is_active" name="is_active"
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @if($user->id === auth()->id())
                                        <input type="hidden" name="is_active" value="1">
                                        <small class="form-text">You cannot deactivate your own account</small>
                                    @endif
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <h6 class="mb-3" style="color: #f8fafc;">
                            <i class="bi bi-key me-2"></i>Change Password (Optional)
                        </h6>
                        <p style="color: #94a3b8; font-size: 0.875rem;" class="mb-3">Leave password fields empty to keep current password</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="modern-form-label">New Password</label>
                                    <input type="password" class="form-control modern-form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Minimum 8 characters required</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="modern-form-label">Confirm New Password</label>
                                    <input type="password" class="form-control modern-form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <!-- Customer Specific Fields -->
                        @if($user->isCustomer())
                        <div id="customerFields" class="customer-fields-section">
                            <h6 class="mb-3" style="color: #f8fafc;">
                                <i class="bi bi-person-badge me-2"></i>Customer Information
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_name" class="modern-form-label">Customer Name *</label>
                                        <input type="text" class="form-control modern-form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" name="customer_name" 
                                               value="{{ old('customer_name', $user->customer->nm_pelanggan ?? '') }}" required>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_phone" class="modern-form-label">Phone Number *</label>
                                        <input type="text" class="form-control modern-form-control @error('customer_phone') is-invalid @enderror" 
                                               id="customer_phone" name="customer_phone" 
                                               value="{{ old('customer_phone', $user->customer->telpon ?? '') }}" required>
                                        @error('customer_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_address" class="modern-form-label">Address *</label>
                                <textarea class="form-control modern-form-control @error('customer_address') is-invalid @enderror" 
                                          id="customer_address" name="customer_address" rows="3" required>{{ old('customer_address', $user->customer->alamat ?? '') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_city" class="modern-form-label">City *</label>
                                        <input type="text" class="form-control modern-form-control @error('customer_city') is-invalid @enderror" 
                                               id="customer_city" name="customer_city" 
                                               value="{{ old('customer_city', $user->customer->kota ?? '') }}" required>
                                        @error('customer_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_email" class="modern-form-label">Customer Email</label>
                                        <input type="email" class="form-control modern-form-control @error('customer_email') is-invalid @enderror" 
                                               id="customer_email" name="customer_email" 
                                               value="{{ old('customer_email', $user->customer->email ?? '') }}">
                                        @error('customer_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text">Optional - can be different from login email</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="birth_date" class="modern-form-label">Birth Date</label>
                                        <input type="date" class="form-control modern-form-control @error('birth_date') is-invalid @enderror" 
                                               id="birth_date" name="birth_date" 
                                               value="{{ old('birth_date', $user->customer->tanggal_lahir?->format('Y-m-d') ?? '') }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="modern-form-label">Gender</label>
                                        <select class="form-select modern-form-control @error('gender') is-invalid @enderror" 
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
                        <div id="customerFields" class="customer-fields-section" style="display: none;">
                            <h6 class="mb-3" style="color: #f8fafc;">
                                <i class="bi bi-person-badge me-2"></i>Customer Information
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_name" class="modern-form-label">Customer Name *</label>
                                        <input type="text" class="form-control modern-form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_phone" class="modern-form-label">Phone Number *</label>
                                        <input type="text" class="form-control modern-form-control @error('customer_phone') is-invalid @enderror" 
                                               id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                                        @error('customer_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_address" class="modern-form-label">Address *</label>
                                <textarea class="form-control modern-form-control @error('customer_address') is-invalid @enderror" 
                                          id="customer_address" name="customer_address" rows="3">{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_city" class="modern-form-label">City *</label>
                                        <input type="text" class="form-control modern-form-control @error('customer_city') is-invalid @enderror" 
                                               id="customer_city" name="customer_city" value="{{ old('customer_city') }}">
                                        @error('customer_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_email" class="modern-form-label">Customer Email</label>
                                        <input type="email" class="form-control modern-form-control @error('customer_email') is-invalid @enderror" 
                                               id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                        @error('customer_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text">Optional - can be different from login email</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="birth_date" class="modern-form-label">Birth Date</label>
                                        <input type="date" class="form-control modern-form-control @error('birth_date') is-invalid @enderror" 
                                               id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="modern-form-label">Gender</label>
                                        <select class="form-select modern-form-control @error('gender') is-invalid @enderror" 
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

                        <div class="section-divider"></div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small style="color: #94a3b8;">
                                    Last updated: {{ $user->updated_at->format('F d, Y H:i') }}
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="modern-btn-outline-info">
                                    <i class="bi bi-eye me-2"></i>View Details
                                </a>
                                <button type="submit" class="modern-btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Activity Summary -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-activity me-2"></i>User Activity Summary
                    </h6>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-value text-primary">{{ $user->sales()->count() }}</div>
                                <div class="stats-label">Sales Processed</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-value text-success">{{ $user->purchases()->count() }}</div>
                                <div class="stats-label">Purchase Orders</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-value text-info">{{ $user->created_at->diffInDays(now()) }}</div>
                                <div class="stats-label">Days Active</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-value text-warning">{{ $user->updated_at->diffForHumans() }}</div>
                                <div class="stats-label">Last Activity</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($user->id !== auth()->id())
            <div class="danger-zone-card">
                <div class="danger-zone-header">
                    <h6 class="mb-0 text-white">
                        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                    </h6>
                </div>
                <div class="danger-zone-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 style="color: #ef4444;">Delete User Account</h6>
                            <p style="color: #94a3b8;" class="mb-0">
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
                                    <br><strong style="color: #fbbf24;">Note: This user has transaction history and cannot be deleted.</strong>
                                @endif
                                @if($hasCustomerOrders)
                                    <br><strong style="color: #fbbf24;">Note: This customer has order history and cannot be deleted.</strong>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($canDelete)
                                <button type="button" class="modern-btn-danger" 
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                    <i class="bi bi-trash me-2"></i>Delete User
                                </button>
                            @else
                                <button type="button" class="modern-btn-outline-danger" disabled>
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
                <h5 class="modal-title" style="color: #ef4444;">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p style="color: #ef4444;" class="mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="modern-btn-outline" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modern-btn-danger">
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