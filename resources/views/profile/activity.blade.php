@extends('layouts.app')

@section('title', 'Activity History')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}">Profile Settings</a></li>
        <li class="breadcrumb-item active">Activity History</li>
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

            <!-- Statistics Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Activity Summary
                    </h6>
                </div>
                <div class="card-body">
                    @if($user->isCustomer())
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Total Purchases</span>
                            <span class="badge bg-primary fs-6">{{ $stats['total_purchases'] ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Total Spent</span>
                            <span class="fw-bold text-success">${{ number_format($stats['total_spent'] ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Recent Activities</span>
                            <span class="badge bg-info fs-6">{{ count($recentActivities) }}</span>
                        </div>
                    @elseif($user->isPharmacist() || $user->isAdmin())
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Sales Processed</span>
                            <span class="badge bg-primary fs-6">{{ $stats['sales_processed'] ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Purchase Orders</span>
                            <span class="badge bg-info fs-6">{{ $stats['purchases_created'] ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Sales Value</span>
                            <span class="fw-bold text-success">${{ number_format($stats['total_sales_value'] ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Purchase Value</span>
                            <span class="fw-bold text-warning">${{ number_format($stats['total_purchases_value'] ?? 0, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Profile
                        </a>
                        @if($user->isCustomer())
                            <a href="{{ route('sales.index') }}" class="btn btn-outline-success">
                                <i class="bi bi-cart-check me-2"></i>My Purchases
                            </a>
                        @elseif($user->isPharmacist() || $user->isAdmin())
                            <a href="{{ route('sales.index') }}" class="btn btn-outline-success">
                                <i class="bi bi-cart-check me-2"></i>Sales History
                            </a>
                            <a href="{{ route('purchases.index') }}" class="btn btn-outline-info">
                                <i class="bi bi-bag me-2"></i>Purchase Orders
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Activity Timeline -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Recent Activity History
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($recentActivities) > 0)
                        <div class="timeline">
                            @foreach($recentActivities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $activity['type'] === 'purchase' ? 'primary' : ($activity['type'] === 'sale_processed' ? 'success' : 'info') }}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="timeline-title mb-1">
                                                    @if($activity['type'] === 'purchase')
                                                        <i class="bi bi-cart-check me-2 text-primary"></i>Purchase Made
                                                    @elseif($activity['type'] === 'sale_processed')
                                                        <i class="bi bi-cash-coin me-2 text-success"></i>Sale Processed
                                                    @elseif($activity['type'] === 'purchase_created')
                                                        <i class="bi bi-bag-plus me-2 text-info"></i>Purchase Order Created
                                                    @endif
                                                </h6>
                                                <p class="timeline-text mb-1">{{ $activity['description'] }}</p>
                                                <small class="text-muted">
                                                    {{ $activity['date']->format('F d, Y H:i') }} 
                                                    ({{ $activity['date']->diffForHumans() }})
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold {{ $activity['type'] === 'purchase' ? 'text-primary' : 'text-success' }}">
                                                    ${{ number_format($activity['amount'], 2) }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($activity['type'] === 'purchase' && isset($activity['details']))
                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" 
                                                        data-bs-toggle="collapse" data-bs-target="#activity-{{ $loop->index }}" 
                                                        aria-expanded="false">
                                                    <i class="bi bi-eye me-1"></i>View Details
                                                </button>
                                                <div class="collapse mt-2" id="activity-{{ $loop->index }}">
                                                    <div class="card card-body bg-light">
                                                        <h6 class="mb-2">Purchase Details</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-borderless">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Drug</th>
                                                                        <th>Qty</th>
                                                                        <th>Price</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($activity['details']->saleDetails as $detail)
                                                                        <tr>
                                                                            <td>{{ $detail->drug->nm_obat }}</td>
                                                                            <td>{{ $detail->jumlah }}</td>
                                                                            <td>${{ number_format($detail->harga_satuan, 2) }}</td>
                                                                            <td>${{ number_format($detail->subtotal, 2) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="text-end">
                                                            <strong>Total: ${{ number_format($activity['details']->total_after_discount, 2) }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Load More Activities -->
                        <div class="text-center mt-4">
                            <p class="text-muted">
                                Showing {{ count($recentActivities) }} recent activities.
                                @if($user->isCustomer())
                                    <a href="{{ route('sales.index') }}" class="ms-2">View all purchases →</a>
                                @else
                                    <a href="{{ route('sales.index') }}" class="ms-2">View all sales →</a>
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-clock-history display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No Activity Yet</h5>
                            <p class="text-muted">
                                @if($user->isCustomer())
                                    Start shopping to see your purchase history here.
                                @else
                                    Your sales and purchase activities will appear here.
                                @endif
                            </p>
                            @if($user->isCustomer())
                                <a href="{{ route('drugs.index') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-search me-2"></i>Browse Drugs
                                </a>
                            @else
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('sales.create') }}" class="btn btn-success">
                                        <i class="bi bi-plus-circle me-2"></i>New Sale
                                    </a>
                                    <a href="{{ route('purchases.create') }}" class="btn btn-info">
                                        <i class="bi bi-bag-plus me-2"></i>New Purchase Order
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -26px;
    top: 20px;
    height: calc(100% - 10px);
    width: 2px;
    background-color: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.timeline-title {
    font-size: 0.95rem;
    margin-bottom: 5px;
}

.timeline-text {
    color: #6c757d;
    font-size: 0.9rem;
}
</style>
@endsection