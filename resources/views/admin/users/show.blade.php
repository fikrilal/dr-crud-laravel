@extends('layouts.app')

@section('title', 'User Details')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User Management</a></li>
        <li class="breadcrumb-item active">User Details</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- User Profile Card -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=ffffff&size=120" 
                         alt="Avatar" class="rounded-circle mb-3" width="120" height="120">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center mb-3">
                        <span class="badge bg-label-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'pharmacist' ? 'success' : 'info') }} me-2">
                            {{ ucfirst($user->user_type) }}
                        </span>
                        <span class="badge bg-label-{{ $user->is_active ? 'success' : 'secondary' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <small class="text-muted">
                        Member since {{ $user->created_at->format('F d, Y') }}
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Account Age</span>
                        <span class="fw-bold">{{ $stats['account_age'] }} days</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Sales Processed</span>
                        <span class="badge bg-primary fs-6">{{ $stats['total_sales'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Purchase Orders</span>
                        <span class="badge bg-success fs-6">{{ $stats['total_purchases'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Last Activity</span>
                        <span class="text-muted small">{{ $stats['last_activity']->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Users
                        </a>
                        @if($user->user_type !== 'customer')
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit User
                            </a>
                            @if($user->id !== auth()->id())
                                <button type="button" class="btn btn-outline-warning" 
                                        onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})">
                                    <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }} me-2"></i>
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} Account
                                </button>
                            @endif
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Customer accounts are read-only in this interface.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="col-lg-8">
            <!-- Account Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>Account Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">User ID:</td>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Full Name:</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">User Type:</td>
                                    <td>
                                        <span class="badge bg-label-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'pharmacist' ? 'success' : 'info') }}">
                                            {{ ucfirst($user->user_type) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Status:</td>
                                    <td>
                                        <span class="badge bg-label-{{ $user->is_active ? 'success' : 'secondary' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email Verified:</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-label-success">
                                                <i class="bi bi-check-circle me-1"></i>Verified
                                            </span>
                                            <br><small class="text-muted">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="badge bg-label-warning">
                                                <i class="bi bi-clock me-1"></i>Not Verified
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Created:</td>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Last Updated:</td>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details (if customer) -->
            @if($user->isCustomer() && $user->customer)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-badge me-2"></i>Customer Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Customer ID:</td>
                                    <td>{{ $user->customer->kd_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Customer Name:</td>
                                    <td>{{ $user->customer->nm_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Phone:</td>
                                    <td>{{ $user->customer->telpon ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email:</td>
                                    <td>{{ $user->customer->email ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Address:</td>
                                    <td>{{ $user->customer->alamat ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">City:</td>
                                    <td>{{ $user->customer->kota ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Birth Date:</td>
                                    <td>{{ $user->customer->tanggal_lahir ? $user->customer->tanggal_lahir->format('M d, Y') : 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Gender:</td>
                                    <td>{{ $user->customer->jenis_kelamin == 'L' ? 'Male' : ($user->customer->jenis_kelamin == 'P' ? 'Female' : 'Not specified') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Activity History -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->sales()->count() > 0 || $user->purchases()->count() > 0)
                        <div class="row">
                            @if($user->sales()->count() > 0)
                            <div class="col-md-6">
                                <h6 class="text-primary">
                                    <i class="bi bi-cart-check me-2"></i>Recent Sales ({{ $user->sales()->count() }} total)
                                </h6>
                                <div class="list-group list-group-flush">
                                    @foreach($user->sales()->latest()->limit(5)->get() as $sale)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Sale #{{ $sale->nota }}</h6>
                                                    <p class="mb-1 text-muted small">
                                                        Total: Rp {{ number_format($sale->total_after_discount, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <small class="text-muted">{{ $sale->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($user->purchases()->count() > 0)
                            <div class="col-md-6">
                                <h6 class="text-success">
                                    <i class="bi bi-bag-plus me-2"></i>Recent Purchase Orders ({{ $user->purchases()->count() }} total)
                                </h6>
                                <div class="list-group list-group-flush">
                                    @foreach($user->purchases()->latest()->limit(5)->get() as $purchase)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">PO #{{ $purchase->nota }}</h6>
                                                    <p class="mb-1 text-muted small">
                                                        Total: Rp {{ number_format($purchase->total_after_discount, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <small class="text-muted">{{ $purchase->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clock-history display-4 text-muted mb-3"></i>
                            <h6 class="text-muted">No Activity Yet</h6>
                            <p class="text-muted mb-0">This user hasn't performed any transactions yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleUserStatus(userId, newStatus) {
    const action = newStatus === 'true' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this user account?`)) {
        fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Failed to update user status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating user status');
        });
    }
}
</script>
@endpush