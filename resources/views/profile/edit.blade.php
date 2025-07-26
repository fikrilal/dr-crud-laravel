@extends('layouts.app')

@section('title', 'Profile Settings')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Profile Settings</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Overview -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=ffffff&size=120" 
                         alt="Avatar" class="rounded-circle mb-3" width="120" height="120">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted">{{ ucfirst($user->user_type) }}</p>
                    <small class="text-muted">
                        Member since {{ $stats['account_created']->format('F Y') }}
                    </small>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Quick Stats
                    </h6>
                </div>
                <div class="card-body">
                    @if($user->isCustomer())
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-primary fs-4">{{ $stats['total_purchases'] ?? 0 }}</span>
                                    <small class="text-muted">Total Purchases</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-success fs-4">${{ number_format($stats['total_spent'] ?? 0, 2) }}</span>
                                    <small class="text-muted">Total Spent</small>
                                </div>
                            </div>
                        </div>
                    @elseif($user->isPharmacist() || $user->isAdmin())
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-primary fs-4">{{ $stats['sales_processed'] ?? 0 }}</span>
                                    <small class="text-muted">Sales Processed</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-info fs-4">{{ $stats['purchases_created'] ?? 0 }}</span>
                                    <small class="text-muted">Orders Created</small>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center mt-3">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-success fs-6">${{ number_format($stats['total_sales_value'] ?? 0, 2) }}</span>
                                    <small class="text-muted">Sales Value</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-warning fs-6">${{ number_format($stats['total_purchases_value'] ?? 0, 2) }}</span>
                                    <small class="text-muted">Purchase Value</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            <div class="card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills">
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
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-person me-2"></i>Profile Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-4">Update your account's profile information and email address.</p>
                            
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
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
                                            <label class="form-label">User Type</label>
                                            <input type="text" class="form-control" value="{{ ucfirst($user->user_type) }}" readonly>
                                            <small class="form-text text-muted">Contact admin to change user type.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Status</label>
                                            <div class="form-control d-flex align-items-center">
                                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                {{ $user->is_active ? 'Account is active' : 'Account is deactivated' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($user->email_verified_at === null)
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Your email address is unverified.
                                        <button type="button" class="btn btn-outline-warning btn-sm ms-2" onclick="resendVerification()">
                                            Resend Verification Email
                                        </button>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Update Profile
                                    </button>
                                    <small class="text-muted align-self-center">
                                        Last updated: {{ $user->updated_at->format('F d, Y H:i') }}
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password & Security Tab -->
                <div class="tab-pane fade" id="password-security">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-shield-lock me-2"></i>Password & Security
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-4">Ensure your account is using a long, random password to stay secure.</p>
                            
                            <form method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password *</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password *</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Minimum 8 characters required.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-key me-2"></i>Update Password
                                </button>
                            </form>

                            <hr class="my-4">

                            <!-- Account Deletion -->
                            <div class="alert alert-danger">
                                <h6 class="alert-heading">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                                </h6>
                                <p class="mb-3">
                                    Once your account is deleted, all of its resources and data will be permanently deleted. 
                                    Before deleting your account, please download any data or information that you wish to retain.
                                </p>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="bi bi-trash me-2"></i>Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Details Tab -->
                @if($user->isCustomer() && $user->customer)
                <div class="tab-pane fade" id="customer-details">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-card-text me-2"></i>Personal Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-4">Update your personal information and contact details.</p>
                            
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_name" class="form-label">Customer Name *</label>
                                            <input type="text" class="form-control @error('customer_info.nm_pelanggan') is-invalid @enderror" 
                                                   id="customer_name" name="customer_info[nm_pelanggan]" 
                                                   value="{{ old('customer_info.nm_pelanggan', $user->customer->nm_pelanggan) }}" required>
                                            @error('customer_info.nm_pelanggan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_phone" class="form-label">Phone Number *</label>
                                            <input type="text" class="form-control @error('customer_info.telpon') is-invalid @enderror" 
                                                   id="customer_phone" name="customer_info[telpon]" 
                                                   value="{{ old('customer_info.telpon', $user->customer->telpon) }}" required>
                                            @error('customer_info.telpon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Address *</label>
                                    <textarea class="form-control @error('customer_info.alamat') is-invalid @enderror" 
                                              id="customer_address" name="customer_info[alamat]" rows="3" required>{{ old('customer_info.alamat', $user->customer->alamat) }}</textarea>
                                    @error('customer_info.alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_city" class="form-label">City *</label>
                                            <input type="text" class="form-control @error('customer_info.kota') is-invalid @enderror" 
                                                   id="customer_city" name="customer_info[kota]" 
                                                   value="{{ old('customer_info.kota', $user->customer->kota) }}" required>
                                            @error('customer_info.kota')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_email" class="form-label">Customer Email</label>
                                            <input type="email" class="form-control @error('customer_info.email') is-invalid @enderror" 
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
                                            <label for="birth_date" class="form-label">Birth Date</label>
                                            <input type="date" class="form-control @error('customer_info.tanggal_lahir') is-invalid @enderror" 
                                                   id="birth_date" name="customer_info[tanggal_lahir]" 
                                                   value="{{ old('customer_info.tanggal_lahir', $user->customer->tanggal_lahir?->format('Y-m-d')) }}">
                                            @error('customer_info.tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select @error('customer_info.jenis_kelamin') is-invalid @enderror" 
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

                                <button type="submit" class="btn btn-primary">
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
                        <label for="delete_password" class="form-label">Enter your password to confirm:</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Verification Form -->
<form id="verification-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
function resendVerification() {
    if (confirm('Send a new verification email?')) {
        document.getElementById('verification-form').submit();
    }
}

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