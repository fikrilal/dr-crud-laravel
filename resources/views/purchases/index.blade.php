@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Purchase Orders</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header with Create Button -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-cart-plus me-2"></i>Purchase Orders
                </h4>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>New Purchase Order
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('purchases.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Purchase number, supplier...">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="supplier" class="form-label">Supplier</label>
                    <select class="form-select" id="supplier" name="supplier">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->kd_supplier }}" {{ request('supplier') == $supplier->kd_supplier ? 'selected' : '' }}>
                                {{ $supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Purchase Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Purchase #</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>
                                    <a href="{{ route('purchases.show', $purchase->nota) }}" class="text-decoration-none fw-bold">
                                        {{ $purchase->nota }}
                                    </a>
                                </td>
                                <td>{{ $purchase->tgl_nota->format('M d, Y') }}</td>
                                <td>
                                    <div>
                                        <div class="fw-semibold">{{ $purchase->supplier->nama_supplier }}</div>
                                        <small class="text-muted">{{ $purchase->supplier->kd_supplier }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $purchase->total_items }} items</span>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold">${{ number_format($purchase->total_after_discount, 2) }}</div>
                                        @if($purchase->diskon > 0)
                                            <small class="text-muted">
                                                <s>${{ number_format($purchase->total_before_discount, 2) }}</s>
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $purchase->status_badge }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $purchase->user->name }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('purchases.show', $purchase->nota) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            @if($purchase->status === 'pending')
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('purchases.edit', $purchase->nota) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('purchases.receive', $purchase->nota) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-success" 
                                                                onclick="return confirm('Mark this purchase as received? This will update drug stock.')">
                                                            <i class="bi bi-check-circle me-2"></i>Mark as Received
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('purchases.cancel', $purchase->nota) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-warning" 
                                                                onclick="return confirm('Cancel this purchase order?')">
                                                            <i class="bi bi-x-circle me-2"></i>Cancel
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('purchases.destroy', $purchase->nota) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                onclick="return confirm('Delete this purchase order permanently?')">
                                                            <i class="bi bi-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-cart-plus display-1 mb-3"></i>
                                        <br>No purchase orders found.
                                        <br><a href="{{ route('purchases.create') }}" class="btn btn-primary mt-2">Create First Purchase Order</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($purchases->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $purchases->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection