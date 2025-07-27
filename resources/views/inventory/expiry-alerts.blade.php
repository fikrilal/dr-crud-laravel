@extends('layouts.app')

@section('title', 'Expiry Alerts')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Expiry Alerts</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header with Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="card-title mb-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>Drug Expiry Alerts
                            </h4>
                            <p class="card-text mb-0">Monitor drug expiration dates and prevent stock losses.</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <form method="GET" class="d-inline-flex gap-2 align-items-center">
                                <select name="days" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="30" {{ $filterDays == '30' ? 'selected' : '' }}>Next 30 Days</option>
                                    <option value="60" {{ $filterDays == '60' ? 'selected' : '' }}>Next 60 Days</option>
                                    <option value="90" {{ $filterDays == '90' ? 'selected' : '' }}>Next 90 Days</option>
                                    <option value="180" {{ $filterDays == '180' ? 'selected' : '' }}>Next 6 Months</option>
                                    <option value="365" {{ $filterDays == '365' ? 'selected' : '' }}>Next Year</option>
                                </select>
                                <select name="type" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="all" {{ $alertType == 'all' ? 'selected' : '' }}>All Alerts</option>
                                    <option value="expired" {{ $alertType == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="critical" {{ $alertType == 'critical' ? 'selected' : '' }}>Critical</option>
                                    <option value="warning" {{ $alertType == 'warning' ? 'selected' : '' }}>Warning</option>
                                    <option value="notice" {{ $alertType == 'notice' ? 'selected' : '' }}>Notice</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-danger">
                            <i class="bi bi-x-circle fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title text-danger">{{ $stats['expired_count'] }}</h3>
                    <p class="card-text text-muted small">Expired</p>
                    <small class="text-danger">Rp {{ number_format($stats['total_expired_value'], 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-danger">
                            <i class="bi bi-exclamation-triangle fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title text-danger">{{ $stats['critical_count'] }}</h3>
                    <p class="card-text text-muted small">Critical (≤30 days)</p>
                    <small class="text-danger">Rp {{ number_format($stats['total_critical_value'], 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="bi bi-exclamation-circle fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title text-warning">{{ $stats['warning_count'] }}</h3>
                    <p class="card-text text-muted small">Warning (≤90 days)</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-info">
                            <i class="bi bi-info-circle fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title text-info">{{ $stats['notice_count'] }}</h3>
                    <p class="card-text text-muted small">Notice (≤180 days)</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="bi bi-check-circle fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title text-success">{{ $stats['good_count'] }}</h3>
                    <p class="card-text text-muted small">Good (>180 days)</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="bi bi-capsule fs-4"></i>
                        </span>
                    </div>
                    <h3 class="card-title text-primary">{{ $stats['total_drugs'] }}</h3>
                    <p class="card-text text-muted small">Total Active</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Alert -->
    @if($stats['total_at_risk_value'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger">
                <h5><i class="bi bi-exclamation-triangle me-2"></i>Attention Required</h5>
                <p class="mb-2">
                    <strong>{{ $stats['expired_count'] + $stats['critical_count'] + $stats['warning_count'] }}</strong> drugs require immediate attention.
                    Total value at risk: <strong>Rp {{ number_format($stats['total_at_risk_value'], 0, ',', '.') }}</strong>
                </p>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="generateReport()">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Generate Report
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="markAllChecked()">
                        <i class="bi bi-check-all me-1"></i>Mark All as Reviewed
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Expiry Alerts Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>Drug Expiry Details
            </h5>
            <span class="badge bg-primary">{{ $expiryData->count() }} items</span>
        </div>
        <div class="card-body p-0">
            @if($expiryData->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Drug Information</th>
                                <th>Stock</th>
                                <th>Estimated Expiry</th>
                                <th>Days Left</th>
                                <th>Alert Level</th>
                                <th>Stock Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiryData as $item)
                            <tr class="{{ $item['is_expired'] ? 'table-danger' : ($item['alert_level'] == 'critical' ? 'table-warning' : '') }}">
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $item['drug']->nm_obat }}</h6>
                                        <small class="text-muted">
                                            Code: {{ $item['drug']->kd_obat }} | 
                                            Type: {{ $item['drug']->jenis }} |
                                            Form: {{ $item['drug']->satuan }}
                                        </small>
                                        @if($item['drug']->supplier)
                                        <br><small class="text-info">Supplier: {{ $item['drug']->supplier->nm_supplier }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $item['drug']->stok }}</span> units
                                    <br><small class="text-muted">Min: {{ $item['drug']->min_stock_level ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <div>
                                        {{ $item['estimated_expiry']->format('M d, Y') }}
                                        <br><small class="text-muted">{{ $item['estimated_expiry']->format('D') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($item['is_expired'])
                                        <span class="badge bg-danger">
                                            {{ abs($item['days_until_expiry']) }} days overdue
                                        </span>
                                    @else
                                        <span class="fw-bold {{ $item['days_until_expiry'] <= 30 ? 'text-danger' : ($item['days_until_expiry'] <= 90 ? 'text-warning' : 'text-success') }}">
                                            {{ $item['days_until_expiry'] }} days
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'expired' => 'bg-danger',
                                            'critical' => 'bg-danger',
                                            'warning' => 'bg-warning',
                                            'notice' => 'bg-info',
                                            'good' => 'bg-success'
                                        ][$item['alert_level']] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($item['alert_level']) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">Rp {{ number_format($item['stock_value'], 0, ',', '.') }}</span>
                                    <br><small class="text-muted">@ Rp {{ number_format($item['drug']->harga_jual, 0, ',', '.') }}/unit</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('drugs.show', $item['drug']->kd_obat) }}">
                                                    <i class="bi bi-eye me-2"></i>View Drug Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('drugs.edit', $item['drug']->kd_obat) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit Drug Info
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button type="button" class="dropdown-item" onclick="markAsChecked('{{ $item['drug']->kd_obat }}')">
                                                    <i class="bi bi-check-circle me-2"></i>Mark as Checked
                                                </button>
                                            </li>
                                            @if($item['is_expired'] || $item['alert_level'] == 'critical')
                                            <li>
                                                <button type="button" class="dropdown-item text-warning" onclick="createDiscountSale('{{ $item['drug']->kd_obat }}')">
                                                    <i class="bi bi-percent me-2"></i>Create Discount Sale
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
            @else
                <div class="text-center py-5">
                    <i class="bi bi-check-circle-fill display-1 text-success mb-3"></i>
                    <h5 class="text-success">All Clear!</h5>
                    <p class="text-muted">No drugs matching your filter criteria require attention at this time.</p>
                    <a href="?days=365&type=all" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-2"></i>View All Drugs
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function markAsChecked(drugId) {
    fetch(`/expiry-alerts/${drugId}/mark-checked`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message and optionally refresh
            alert('Drug marked as checked successfully');
            // You could add visual feedback here
        } else {
            alert('Failed to mark drug as checked');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function generateReport(type = 'all') {
    const params = new URLSearchParams({
        type: type,
        days: '{{ $filterDays }}',
        format: 'pdf'
    });
    
    fetch(`/expiry-alerts/report?${params}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Report generation feature would download the file here');
        } else {
            alert('Failed to generate report');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while generating report');
    });
}

function markAllChecked() {
    if (confirm('Mark all visible drugs as checked?')) {
        alert('Bulk mark as checked feature would be implemented here');
    }
}

function createDiscountSale(drugId) {
    if (confirm('Create a discounted sale for this soon-to-expire drug?')) {
        // Redirect to sales page with pre-filled drug and suggested discount
        window.location.href = `/sales/create?drug=${drugId}&discount=true`;
    }
}

// Auto-refresh every 5 minutes to keep expiry data current
setInterval(function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 300000);
</script>
@endpush