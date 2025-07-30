@extends('layouts.app')

@section('title', 'Profile Settings')

@push('styles')
<style>
/* Modern Profile Page Styles */
.modern-profile-header {
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

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #3b82f6;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
    margin-bottom: 1rem;
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
    font-size: 1.5rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #cbd5e1;
    font-size: 0.875rem;
}

.modern-nav-pills .nav-link {
    background: transparent;
    border: 1px solid #475569;
    color: #e2e8f0;
    margin-bottom: 0.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.modern-nav-pills .nav-link:hover {
    background: #334155;
    border-color: #3b82f6;
    color: #e2e8f0;
}

.modern-nav-pills .nav-link.active {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-color: #3b82f6;
    color: white;
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

.modern-btn-secondary {
    background: #475569;
    border: none;
    color: #e2e8f0;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.modern-btn-secondary:hover {
    background: #334155;
    color: #e2e8f0;
    text-decoration: none;
}

.modern-badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
}

.modern-badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white !important;
}

.modern-badge.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    color: white !important;
}

.modern-alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 12px;
    padding: 1.5rem;
    color: #f87171;
}

.invalid-feedback {
    color: #ef4444 !important;
}

.form-text {
    color: #94a3b8 !important;
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
    <div class="modern-profile-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Profile Settings</h2>
                    <p class="mb-0" style="color: #94a3b8;">Manage your account information and preferences</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Modern Profile Overview -->
            <div class="modern-card mb-4">
                <div class="modern-card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=ffffff&size=120" 
                         alt="Avatar" class="profile-avatar">
                    <h5 style="color: #f8fafc; font-weight: 600; margin-bottom: 0.5rem;">{{ $user->name }}</h5>
                    <p style="color: #94a3b8; margin-bottom: 0.5rem;">{{ ucfirst($user->user_type) }}</p>
                    <small style="color: #64748b;">
                        Member since {{ $stats['account_created']->format('F Y') }}
                    </small>
                </div>
            </div>

            <!-- Modern Quick Stats -->
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Quick Stats
                    </h6>
                </div>
                <div class="modern-card-body">
                    @if($user->isCustomer())
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-value text-primary">{{ $stats['total_purchases'] ?? 0 }}</div>
                                    <div class="stats-label">Total Purchases</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-value text-success">${{ number_format($stats['total_spent'] ?? 0, 2) }}</div>
                                    <div class="stats-label">Total Spent</div>
                                </div>
                            </div>
                        </div>
                    @elseif($user->isPharmacist() || $user->isAdmin())
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-value text-primary">{{ $stats['sales_processed'] ?? 0 }}</div>
                                    <div class="stats-label">Sales Processed</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-value text-info">{{ $stats['purchases_created'] ?? 0 }}</div>
                                    <div class="stats-label">Orders Created</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-value text-success">${{ number_format($stats['total_sales_value'] ?? 0, 2) }}</div>
                                    <div class="stats-label">Sales Value</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-value text-warning">${{ number_format($stats['total_purchases_value'] ?? 0, 2) }}</div>
                                    <div class="stats-label">Purchase Value</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modern Navigation -->
            <div class="modern-card">
                <div class="modern-card-body">
                    <div class="nav flex-column modern-nav-pills">
                        <a class="nav-link active" href="#profile-info" data-bs-toggle="pill">
                            <i class="bi bi-person me-2"></i>Profile Information
                        </a>
                        <a class="nav-link" href="#password-security" data-bs-toggle="pill">
                            <i class="bi bi-shield-lock me-2"></i>Password & Security
                        </a>
                        @if($user->isCustomer() && $user->customer)
                            <a class="nav-link" href="#customer-details" data-bs-toggle="pill">
                                <i class="bi bi-card-text me-2"></i>Personal Details
                            </a>
                        @endif
                        <a class="nav-link" href="{{ route('profile.activity') }}">
                            <i class="bi bi-clock-history me-2"></i>Activity History
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="tab-content">
                <!-- Profile Information Tab -->
                <div class="tab-pane fade show active" id="profile-info">
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-person me-2"></i>Profile Information
                            </h5>
                        </div>
                        <div class="modern-card-body">
                            <p style="color: #94a3b8; margin-bottom: 2rem;">Update your account's profile information and email address.</p>
                            
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="modern-form-label">Full Name *</label>
                                            <input type="text" class="form-control modern-form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
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
                                            <label class="modern-form-label">User Type</label>
                                            <input type="text" class="form-control modern-form-control" value="{{ ucfirst($user->user_type) }}" readonly>
                                            <small class="form-text">Contact admin to change user type.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="modern-form-label">Account Status</label>
                                            <div class="form-control modern-form-control d-flex align-items-center">
                                                <span class="modern-badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                {{ $user->is_active ? 'Account is active' : 'Account is deactivated' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="modern-btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Update Profile
                                    </button>
                                    <small style="color: #94a3b8;" class="align-self-center">
                                        Last updated: {{ $user->updated_at->format('F d, Y H:i') }}
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password & Security Tab -->
                <div class="tab-pane fade" id="password-security">
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-shield-lock me-2"></i>Password & Security
                            </h5>
                        </div>
                        <div class="modern-card-body">
                            <p style="color: #94a3b8; margin-bottom: 2rem;">Ensure your account is using a long, random password to stay secure.</p>
                            
                            <form method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="modern-form-label">Current Password *</label>
                                    <input type="password" class="form-control modern-form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="modern-form-label">New Password *</label>
                                            <input type="password" class="form-control modern-form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text">Minimum 8 characters required.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="modern-form-label">Confirm New Password *</label>
                                            <input type="password" class="form-control modern-form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="modern-btn-warning">
                                    <i class="bi bi-key me-2"></i>Update Password
                                </button>
                            </form>

                            <hr class="my-4">

                            <!-- Account Deletion -->
                            <div class="modern-alert-danger">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                                </h6>
                                <p class="mb-3">
                                    Once your account is deleted, all of its resources and data will be permanently deleted. 
                                    Before deleting your account, please download any data or information that you wish to retain.
                                </p>
                                <button type="button" class="modern-btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="bi bi-trash me-2"></i>Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Details Tab -->
                @if($user->isCustomer() && $user->customer)
                <div class="tab-pane fade" id="customer-details">
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-card-text me-2"></i>Personal Details
                            </h5>
                        </div>
                        <div class="modern-card-body">
                            <p style="color: #94a3b8; margin-bottom: 2rem;">Update your personal information and contact details.</p>
                            
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_name" class="modern-form-label">Customer Name *</label>
                                            <input type="text" class="form-control modern-form-control @error('customer_info.nm_pelanggan') is-invalid @enderror" 
                                                   id="customer_name" name="customer_info[nm_pelanggan]" 
                                                   value="{{ old('customer_info.nm_pelanggan', $user->customer->nm_pelanggan) }}" required>
                                            @error('customer_info.nm_pelanggan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_phone" class="modern-form-label">Phone Number *</label>
                                            <input type="text" class="form-control modern-form-control @error('customer_info.telpon') is-invalid @enderror" 
                                                   id="customer_phone" name="customer_info[telpon]" 
                                                   value="{{ old('customer_info.telpon', $user->customer->telpon) }}" required>
                                            @error('customer_info.telpon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_address" class="modern-form-label">Address *</label>
                                    <textarea class="form-control modern-form-control @error('customer_info.alamat') is-invalid @enderror" 
                                              id="customer_address" name="customer_info[alamat]" rows="3" required>{{ old('customer_info.alamat', $user->customer->alamat) }}</textarea>
                                    @error('customer_info.alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_city" class="modern-form-label">City *</label>
                                            <input type="text" class="form-control modern-form-control @error('customer_info.kota') is-invalid @enderror" 
                                                   id="customer_city" name="customer_info[kota]" 
                                                   value="{{ old('customer_info.kota', $user->customer->kota) }}" required>
                                            @error('customer_info.kota')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_email" class="modern-form-label">Customer Email</label>
                                            <input type="email" class="form-control modern-form-control @error('customer_info.email') is-invalid @enderror" 
                                                   id="customer_email" name="customer_info[email]" 
                                                   value="{{ old('customer_info.email', $user->customer->email) }}">
                                            @error('customer_info.email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="birth_date" class="modern-form-label">Birth Date</label>
                                            <input type="date" class="form-control modern-form-control @error('customer_info.tanggal_lahir') is-invalid @enderror" 
                                                   id="birth_date" name="customer_info[tanggal_lahir]" 
                                                   value="{{ old('customer_info.tanggal_lahir', $user->customer->tanggal_lahir?->format('Y-m-d')) }}">
                                            @error('customer_info.tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gender" class="modern-form-label">Gender</label>
                                            <select class="form-select modern-form-control @error('customer_info.jenis_kelamin') is-invalid @enderror" 
                                                    id="gender" name="customer_info[jenis_kelamin]">
                                                <option value="">Select Gender</option>
                                                <option value="L" {{ old('customer_info.jenis_kelamin', $user->customer->jenis_kelamin) == 'L' ? 'selected' : '' }}>Male</option>
                                                <option value="P" {{ old('customer_info.jenis_kelamin', $user->customer->jenis_kelamin) == 'P' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('customer_info.jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="modern-btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Personal Details
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    <p>All of your data will be permanently removed from our servers.</p>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="modern-form-label">Enter your password to confirm:</label>
                        <input type="password" class="form-control modern-form-control" id="delete_password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modern-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="modern-btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

// Handle tab navigation
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a hash in the URL to show specific tab
    if (window.location.hash) {
        const hash = window.location.hash;
        const tab = document.querySelector(`a[href="${hash}"]`);
        if (tab) {
            const tabInstance = new bootstrap.Tab(tab);
            tabInstance.show();
        }
    }
    
    // Update URL when tab changes
    document.querySelectorAll('a[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            window.location.hash = e.target.getAttribute('href');
        });
    });
});
</script>
@endpush