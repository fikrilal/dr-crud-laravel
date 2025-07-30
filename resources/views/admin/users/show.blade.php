@extends('layouts.app')

@section('title', 'User Details')

@push('styles')
<style>
/* Modern User Detail Page Styles */
.modern-user-header {
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

.user-profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #3b82f6;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
    margin-bottom: 1.5rem;
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

.modern-badge.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    color: white !important;
}

.modern-badge.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
    color: white !important;
}

.modern-badge.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    color: white !important;
}

.stats-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #334155;
}

.stats-item:last-child {
    border-bottom: none;
}

.stats-label {
    color: #94a3b8;
    font-weight: 500;
}

.stats-value {
    color: #f8fafc;
    font-weight: 600;
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

.info-table {
    width: 100%;
    border-collapse: collapse;
}

.info-table td {
    padding: 0.75rem 0;
    border-bottom: 1px solid #334155;
    vertical-align: top;
}

.info-table td:first-child {
    color: #94a3b8;
    font-weight: 500;
    width: 35%;
}

.info-table td:last-child {
    color: #f8fafc;
    font-weight: 600;
}

.info-table tr:last-child td {
    border-bottom: none;
}

.modern-alert-info {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 12px;
    padding: 1rem;
    color: #60a5fa;
}

.activity-item {
    background: #334155;
    border: 1px solid #475569;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.2s ease;
}

.activity-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.activity-item:last-child {
    margin-bottom: 0;
}

.empty-state-modern {
    padding: 3rem 2rem;
    text-align: center;
    color: #94a3b8;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #64748b, #475569);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header -->
    <div class="modern-user-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">{{ $user->name }}</h2>
                    <p class="mb-0" style="color: #94a3b8;">{{ ucfirst($user->user_type) }} • View detailed user information</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="modern-btn-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Modern User Profile Card -->
        <div class="col-lg-4">
            <div class="modern-card mb-4">
                <div class="modern-card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=ffffff&size=120" 
                         alt="Avatar" class="user-profile-avatar">
                    <h5 style="color: #f8fafc; font-weight: 600; margin-bottom: 0.5rem;">{{ $user->name }}</h5>
                    <p style="color: #94a3b8; margin-bottom: 1rem;">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
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
                        <span class="modern-badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <small style="color: #64748b;">
                        Member since {{ $user->created_at->format('F d, Y') }}
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
                    <div class="stats-item">
                        <span class="stats-label">Account Age</span>
                        <span class="stats-value">{{ $stats['account_age'] }} days</span>
                    </div>
                    <div class="stats-item">
                        <span class="stats-label">Sales Processed</span>
                        <span class="modern-badge bg-primary">{{ $stats['total_sales'] }}</span>
                    </div>
                    <div class="stats-item">
                        <span class="stats-label">Purchase Orders</span>
                        <span class="modern-badge bg-success">{{ $stats['total_purchases'] }}</span>
                    </div>
                    <div class="stats-item">
                        <span class="stats-label">Last Activity</span>
                        <span style="color: #94a3b8; font-size: 0.875rem;">{{ $stats['last_activity']->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Modern Actions -->
            <div class="modern-card">
                <div class="modern-card-body">
                    <div class="d-grid gap-2">
                        @if($user->user_type !== 'customer')
                            <a href="{{ route('admin.users.edit', $user) }}" class="modern-btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit User
                            </a>
                            @if($user->id !== auth()->id())
                                <button type="button" class="modern-btn-warning" 
                                        onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})">
                                    <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }} me-2"></i>
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} Account
                                </button>
                            @endif
                        @else
                            <div class="modern-alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Customer accounts are read-only in this interface.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Detailed Information -->
        <div class="col-lg-8">
            <!-- Modern Account Information -->
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>Account Information
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="info-table">
                                <tr>
                                    <td>User ID:</td>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <td>Full Name:</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td>User Type:</td>
                                    <td>
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
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="info-table">
                                <tr>
                                    <td>Status:</td>
                                    <td>
                                        <span class="modern-badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email Verified:</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="modern-badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Verified
                                            </span>
                                            <br><small style="color: #94a3b8; font-size: 0.8rem;">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="modern-badge bg-warning">
                                                <i class="bi bi-clock me-1"></i>Not Verified
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Created:</td>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Last Updated:</td>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Customer Details (if customer) -->
            @if($user->isCustomer() && $user->customer)
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-badge me-2"></i>Customer Details
                    </h5>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="info-table">
                                <tr>
                                    <td>Customer ID:</td>
                                    <td>{{ $user->customer->kd_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td>Customer Name:</td>
                                    <td>{{ $user->customer->nm_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td>{{ $user->customer->telpon ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $user->customer->email ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="info-table">
                                <tr>
                                    <td>Address:</td>
                                    <td>{{ $user->customer->alamat ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>{{ $user->customer->kota ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td>Birth Date:</td>
                                    <td>{{ $user->customer->tanggal_lahir ? $user->customer->tanggal_lahir->format('M d, Y') : 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td>Gender:</td>
                                    <td>{{ $user->customer->jenis_kelamin == 'L' ? 'Male' : ($user->customer->jenis_kelamin == 'P' ? 'Female' : 'Not specified') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Modern Activity History -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="modern-card-body">
                    @if($user->sales()->count() > 0 || $user->purchases()->count() > 0)
                        <div class="row">
                            @if($user->sales()->count() > 0)
                            <div class="col-md-6">
                                <h6 style="color: #3b82f6; margin-bottom: 1rem;">
                                    <i class="bi bi-cart-check me-2"></i>Recent Sales ({{ $user->sales()->count() }} total)
                                </h6>
                                @foreach($user->sales()->latest()->limit(5)->get() as $sale)
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1" style="color: #f8fafc;">Sale #{{ $sale->nota }}</h6>
                                                <p class="mb-0" style="color: #94a3b8; font-size: 0.875rem;">
                                                    Total: Rp {{ number_format($sale->total_after_discount, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <small style="color: #64748b;">{{ $sale->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif

                            @if($user->purchases()->count() > 0)
                            <div class="col-md-6">
                                <h6 style="color: #10b981; margin-bottom: 1rem;">
                                    <i class="bi bi-bag-plus me-2"></i>Recent Purchase Orders ({{ $user->purchases()->count() }} total)
                                </h6>
                                @foreach($user->purchases()->latest()->limit(5)->get() as $purchase)
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1" style="color: #f8fafc;">PO #{{ $purchase->nota }}</h6>
                                                <p class="mb-0" style="color: #94a3b8; font-size: 0.875rem;">
                                                    Total: Rp {{ number_format($purchase->total_after_discount, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <small style="color: #64748b;">{{ $purchase->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state-modern">
                            <div class="empty-state-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h6 class="fw-bold mb-2" style="color: #f8fafc;">No Activity Yet</h6>
                            <p class="mb-0">This user hasn't performed any transactions yet.</p>
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