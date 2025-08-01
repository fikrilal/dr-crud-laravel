@extends('layouts.app')

@section('title', 'User Management')

@push('styles')
<style>
/* Modern User Management Page Styles */
.modern-users-header {
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

.modern-btn-outline-secondary {
    background: transparent;
    border: 1px solid #64748b;
    color: #64748b;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
}

.modern-btn-outline-secondary:hover {
    background: #64748b;
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

.stats-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.stats-avatar.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stats-avatar.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.stats-avatar.bg-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stats-avatar.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
}

.stats-avatar.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569);
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
    font-weight: 500;
}

.modern-table {
    background: #1e293b !important;
    color: #e2e8f0 !important;
    margin: 0;
}

.modern-table thead th {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-bottom: 1px solid #334155 !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    padding: 1rem !important;
    font-weight: 600;
}

.modern-table tbody tr {
    background: #1e293b !important;
    border-bottom: 1px solid #334155 !important;
}

.modern-table tbody tr:hover {
    background: #334155 !important;
}

.modern-table tbody td {
    color: #e2e8f0 !important;
    border-color: #334155 !important;
    border-left: none !important;
    border-right: none !important;
    padding: 1rem !important;
    vertical-align: middle;
}

.table {
    --bs-table-bg: #1e293b !important;
    --bs-table-color: #e2e8f0 !important;
    --bs-table-border-color: #334155 !important;
    --bs-table-hover-bg: #334155 !important;
    --bs-table-hover-color: #f8fafc !important;
}

.table > :not(caption) > * > * {
    background-color: var(--bs-table-bg) !important;
    color: var(--bs-table-color) !important;
    border-bottom-color: var(--bs-table-border-color) !important;
}

.table-hover > tbody > tr:hover > * {
    background-color: var(--bs-table-hover-bg) !important;
    color: var(--bs-table-hover-color) !important;
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

.modern-badge.bg-secondary {
    background: linear-gradient(135deg, #64748b, #475569) !important;
    color: white !important;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #3b82f6;
    margin-right: 0.75rem;
}

.modern-dropdown-menu {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
}

.modern-dropdown-item {
    color: #e2e8f0 !important;
    transition: all 0.2s ease;
}

.modern-dropdown-item:hover {
    background: #334155 !important;
    color: #f8fafc !important;
}

.modern-dropdown-divider {
    border-color: #334155 !important;
}

.empty-state-modern {
    padding: 4rem 2rem;
    text-align: center;
    color: #94a3b8;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

/* Modern Pagination Styles */
.pagination .page-link {
    background-color: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    margin: 0 2px !important;
    border-radius: 8px !important;
    padding: 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
}

.pagination .page-link:hover {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #f8fafc !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2) !important;
    text-decoration: none !important;
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
}

.pagination .page-item.disabled .page-link {
    background-color: #1e293b !important;
    border-color: #334155 !important;
    color: #64748b !important;
    cursor: not-allowed !important;
    opacity: 0.6 !important;
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
    <!-- Modern Header Section -->
    <div class="modern-users-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">User Management</h2>
                    <p class="mb-0" style="color: #94a3b8;">Manage system users, roles, and permissions</p>
                </div>
            </div>
            <a href="{{ route('admin.users.create') }}" class="modern-btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Modern Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-value">{{ $stats['total_users'] }}</div>
                <div class="stats-label">Total Users</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-danger">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stats-value">{{ $stats['admin_count'] }}</div>
                <div class="stats-label">Admins</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-success">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="stats-value">{{ $stats['pharmacist_count'] }}</div>
                <div class="stats-label">Pharmacists</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-info">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stats-value">{{ $stats['customer_count'] }}</div>
                <div class="stats-label">Customers</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-value">{{ $stats['active_users'] }}</div>
                <div class="stats-label">Active</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="stats-card">
                <div class="stats-avatar bg-secondary">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stats-value">{{ $stats['inactive_users'] }}</div>
                <div class="stats-label">Inactive</div>
            </div>
        </div>
    </div>

    <!-- Modern User Management Table -->
    <div class="modern-card">
        <div class="modern-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Users Directory
                <span class="modern-badge bg-secondary ms-2">{{ $users->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="modern-btn-outline" onclick="exportUsers()" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        
        <!-- Modern Filters -->
        <div class="p-3" style="border-bottom: 1px solid #334155;">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="modern-form-label">Search Users</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background: #475569; border: 1px solid #475569; color: #94a3b8; border-radius: 8px 0 0 8px;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control modern-form-control" name="search" 
                               value="{{ request('search') }}" placeholder="Name or email...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="modern-form-label">User Type</label>
                    <select class="form-select modern-form-control" name="user_type">
                        <option value="">All Types</option>
                        <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pharmacist" {{ request('user_type') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                        <option value="customer" {{ request('user_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="modern-form-label">Status</label>
                    <select class="form-select modern-form-control" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="modern-form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="modern-btn-outline">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="modern-btn-outline">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table table mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Last Activity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=ffffff&size=40" 
                                                 alt="Avatar" class="user-avatar">
                                            <div>
                                                <h6 class="mb-0 fw-bold" style="color: #f8fafc;">{{ $user->name }}</h6>
                                                <small style="color: #94a3b8;">{{ $user->email }}</small>
                                                @if($user->isCustomer() && $user->customer)
                                                    <br><small class="modern-badge bg-info" style="font-size: 0.6875rem;">ID: {{ $user->customer->kd_pelanggan }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
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
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="modern-badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($user->id !== auth()->id())
                                                <button type="button" class="modern-btn-outline-secondary" 
                                                        onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})">
                                                    <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold" style="color: #f8fafc;">{{ $user->created_at->format('M d, Y') }}</div>
                                            <small style="color: #94a3b8;">{{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold" style="color: #f8fafc;">{{ $user->updated_at->format('M d, Y') }}</div>
                                            <small style="color: #94a3b8;">{{ $user->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="modern-btn-outline-secondary dropdown-toggle" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu modern-dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.users.show', $user) }}">
                                                        <i class="bi bi-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item modern-dropdown-item" href="{{ route('admin.users.edit', $user) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit User
                                                    </a>
                                                </li>
                                                @if($user->id !== auth()->id())
                                                    <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                                    <li>
                                                        <button type="button" class="dropdown-item modern-dropdown-item" style="color: #ef4444 !important;" 
                                                                onclick="confirmDelete({{ $user->id }}, {{ json_encode($user->name) }})">
                                                            <i class="bi bi-trash me-2"></i>Delete User
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modern Pagination -->
                <div class="p-3" style="background: #0f172a; border-top: 1px solid #334155; border-radius: 0 0 16px 16px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div style="color: #94a3b8; font-size: 0.875rem;">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </div>
                        <div>
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state-modern">
                    <div class="empty-state-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #f8fafc;">No Users Found</h5>
                    <p class="mb-4">
                        @if(request()->hasAny(['search', 'user_type', 'status']))
                            No users match your current filter criteria. Try adjusting your filters.
                        @else
                            No users have been created yet. Create your first user to get started.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'user_type', 'status']))
                        <a href="{{ route('admin.users.index') }}" class="modern-btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                        </a>
                    @else
                        <a href="{{ route('admin.users.create') }}" class="modern-btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Create First User
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Enhanced Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #1e293b; border: 1px solid #334155; color: #e2e8f0;">
            <div class="modal-header" style="border-bottom: 1px solid #334155;">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm User Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" style="background: rgba(251, 191, 36, 0.1); border: 1px solid #f59e0b; color: #fbbf24;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                
                <p>Are you sure you want to permanently delete the user:</p>
                <div class="text-center p-3" style="background: #334155; border-radius: 8px; margin: 1rem 0;">
                    <strong id="deleteUserName" style="color: #f8fafc; font-size: 1.1rem;"></strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Note: Users with transaction history cannot be deleted and will be deactivated instead.
                    </small>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmDeletion" required>
                    <label class="form-check-label" for="confirmDeletion">
                        I understand that this action will permanently delete the user and cannot be undone.
                    </label>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #334155;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
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
console.log('User management JavaScript loaded');
console.log('Bootstrap available:', typeof bootstrap !== 'undefined');

// Enhanced delete confirmation
function confirmDelete(userId, userName) {
    console.log('confirmDelete called with:', { userId, userName });
    
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteUserNameElement = document.getElementById('deleteUserName');
    const confirmCheckbox = document.getElementById('confirmDeletion');
    const confirmButton = document.getElementById('confirmDeleteBtn');
    
    console.log('Modal elements found:', {
        modal: !!modal,
        deleteForm: !!deleteForm,
        deleteUserNameElement: !!deleteUserNameElement,
        confirmCheckbox: !!confirmCheckbox,
        confirmButton: !!confirmButton
    });
    
    if (!modal || !deleteForm || !deleteUserNameElement) {
        console.error('Required modal elements not found');
        alert('Error: Modal elements not found. Please refresh the page.');
        return;
    }
    
    // Set the form action and user name
    deleteForm.action = `/admin/users/${userId}`;
    deleteUserNameElement.textContent = userName;
    
    // Reset checkbox and button state
    if (confirmCheckbox) {
        confirmCheckbox.checked = false;
    }
    if (confirmButton) {
        confirmButton.disabled = true;
    }
    
    console.log('Modal configured - showing modal...');
    
    // Show the modal - Bootstrap should now be available globally
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

function toggleUserStatus(userId, newStatus) {
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

function exportUsers() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Enable/disable delete button based on checkbox
document.addEventListener('DOMContentLoaded', function() {
    const confirmCheckbox = document.getElementById('confirmDeletion');
    const confirmButton = document.getElementById('confirmDeleteBtn');
    
    if (confirmCheckbox && confirmButton) {
        confirmCheckbox.addEventListener('change', function() {
            confirmButton.disabled = !this.checked;
            console.log('Checkbox changed:', this.checked);
        });
        
        // Form submission with loading state
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                console.log('Delete form submitted');
                confirmButton.disabled = true;
                confirmButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
            });
        }
    }

    // Auto-submit search form on filter change
    const userTypeSelect = document.querySelector('select[name="user_type"]');
    const statusSelect = document.querySelector('select[name="status"]');
    
    if (userTypeSelect) {
        userTypeSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endpush