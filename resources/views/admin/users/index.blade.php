@extends('layouts.app')

@section('title', 'User Management')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">User Management</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="bi bi-people fs-4"></i>
                        </span>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Users</span>
                    <h3 class="card-title mb-0">{{ $stats['total_users'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-danger">
                            <i class="bi bi-shield-check fs-4"></i>
                        </span>
                    </div>
                    <span class="fw-semibold d-block mb-1">Admins</span>
                    <h3 class="card-title mb-0">{{ $stats['admin_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="bi bi-heart-pulse fs-4"></i>
                        </span>
                    </div>
                    <span class="fw-semibold d-block mb-1">Pharmacists</span>
                    <h3 class="card-title mb-0">{{ $stats['pharmacist_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-info">
                            <i class="bi bi-person-check fs-4"></i>
                        </span>
                    </div>
                    <span class="fw-semibold d-block mb-1">Customers</span>
                    <h3 class="card-title mb-0">{{ $stats['customer_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="bi bi-check-circle fs-4"></i>
                        </span>
                    </div>
                    <span class="fw-semibold d-block mb-1">Active</span>
                    <h3 class="card-title mb-0">{{ $stats['active_users'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-secondary">
                            <i class="bi bi-x-circle fs-4"></i>
                        </span>
                    </div>
                    <span class="fw-semibold d-block mb-1">Inactive</span>
                    <h3 class="card-title mb-0">{{ $stats['inactive_users'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-people me-2"></i>User Management
            </h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New User
            </a>
        </div>
        
        <!-- Filters -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="Name or email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">User Type</label>
                    <select class="form-select" name="user_type">
                        <option value="">All Types</option>
                        <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pharmacist" {{ request('user_type') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                        <option value="customer" {{ request('user_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
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
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=ffffff&size=40" 
                                                 alt="Avatar" class="rounded-circle me-3" width="40" height="40">
                                            <div>
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small class="text-muted">{{ $user->email }}</small>
                                                @if($user->isCustomer() && $user->customer)
                                                    <br><small class="badge bg-label-info">ID: {{ $user->customer->kd_pelanggan }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'pharmacist' ? 'success' : 'info') }}">
                                            {{ ucfirst($user->user_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-label-{{ $user->is_active ? 'success' : 'secondary' }} me-2">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($user->user_type !== 'customer' && $user->id !== auth()->id())
                                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                        onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})">
                                                    <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                                        <br><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $user->updated_at->format('M d, Y') }}</span>
                                        <br><small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.users.show', $user) }}">
                                                        <i class="bi bi-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                @if($user->user_type !== 'customer')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.users.edit', $user) }}">
                                                            <i class="bi bi-pencil me-2"></i>Edit User
                                                        </a>
                                                    </li>
                                                    @if($user->id !== auth()->id())
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button type="button" class="dropdown-item text-danger" 
                                                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                                                <i class="bi bi-trash me-2"></i>Delete User
                                                            </button>
                                                        </li>
                                                    @endif
                                                @else
                                                    <li>
                                                        <span class="dropdown-item-text text-muted">
                                                            <i class="bi bi-info-circle me-2"></i>Customer account (read-only)
                                                        </span>
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

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <small class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                            </small>
                        </div>
                        <div class="col-sm-6">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people display-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Users Found</h5>
                    <p class="text-muted">No users match your current filter criteria.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                    </a>
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
function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = `/admin/users/${userId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
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
</script>
@endpush