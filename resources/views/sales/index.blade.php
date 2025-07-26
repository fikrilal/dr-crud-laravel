@extends('layouts.app')

@section('title', 'Sales History')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Sales History</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Sales History</h4>
                    <p class="text-muted mb-0">Track and manage pharmacy sales transactions</p>
                </div>
                <div>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>New Sale
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sales.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search Sales</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Transaction code, customer...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method">
                        <option value="">All Methods</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $method)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Today's Sales</h6>
                            <h4 class="mb-0">${{ number_format($sales->where('created_at', '>=', today())->sum('total_harga'), 2) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cash-coin fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Transactions</h6>
                            <h4 class="mb-0">{{ $sales->where('created_at', '>=', today())->count() }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-receipt fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Avg. Sale</h6>
                            <h4 class="mb-0">${{ $sales->where('created_at', '>=', today())->count() > 0 ? number_format($sales->where('created_at', '>=', today())->avg('total_harga'), 2) : '0.00' }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">This Month</h6>
                            <h4 class="mb-0">${{ number_format($sales->where('created_at', '>=', now()->startOfMonth())->sum('total_harga'), 2) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-calendar-month fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-receipt-cutoff me-2"></i>Sales Transactions
                <span class="badge bg-secondary ms-2">{{ $sales->total() }} total</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-success" onclick="exportToExcel()">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if($sales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">Transaction Code</th>
                                <th width="15%">Date & Time</th>
                                <th width="20%">Customer</th>
                                <th width="15%">Pharmacist</th>
                                <th width="10%">Items</th>
                                <th width="12%">Total</th>
                                <th width="8%">Payment</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $sale->kode_transaksi }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold">{{ $sale->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $sale->created_at->format('H:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($sale->customer)
                                            <div>
                                                <div class="fw-bold">{{ $sale->customer->nama_pelanggan }}</div>
                                                <small class="text-muted">{{ $sale->customer->nomor_telepon }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">Walk-in Customer</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <i class="bi bi-person-circle text-primary fs-5"></i>
                                            </div>
                                            <span>{{ $sale->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $sale->saleDetails->count() }} items</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">${{ number_format($sale->total_harga, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $sale->metode_pembayaran)) }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('sales.show', $sale) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('sales.receipt', $sale) }}" target="_blank">
                                                    <i class="bi bi-receipt me-2"></i>Print Receipt
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-muted" href="#">
                                                    <i class="bi bi-arrow-clockwise me-2"></i>Refund (Coming Soon)
                                                </a></li>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} results
                        </div>
                        {{ $sales->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-receipt display-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No sales found</h5>
                    <p class="text-muted mb-4">
                        @if(request()->has('search') || request()->has('date_from') || request()->has('payment_method'))
                            Try adjusting your search criteria or <a href="{{ route('sales.index') }}">clear filters</a>
                        @else
                            Start by processing your first sale transaction
                        @endif
                    </p>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create First Sale
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportToExcel() {
    // Implementation for export functionality
    alert('Export functionality will be implemented in the next phase');
}

// Auto-submit search form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodSelect = document.getElementById('payment_method');
    
    paymentMethodSelect.addEventListener('change', function() {
        this.form.submit();
    });

    // Set max date for date inputs to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_from').max = today;
    document.getElementById('date_to').max = today;
});
</script>
@endpush 