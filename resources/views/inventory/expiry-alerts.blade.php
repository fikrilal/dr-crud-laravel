@extends('layouts.app')

@section('title', 'Expiry Alerts')

@push('styles')
<style>
/* Modern Expiry Alerts Page Styles */
.modern-expiry-header {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #e2e8f0;
}

.modern-stat-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.modern-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
    border-color: #3b82f6;
}

.modern-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.stat-expired {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
}

.stat-critical {
    background: linear-gradient(135deg, #ea580c, #c2410c);
    color: white;
}

.stat-warning {
    background: linear-gradient(135deg, #d97706, #b45309);
    color: white;
}

.stat-notice {
    background: linear-gradient(135deg, #0284c7, #0369a1);
    color: white;
}

.stat-good {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
}

.stat-total {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.modern-stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 0.5rem;
}

.modern-stat-label {
    color: #cbd5e1;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.modern-stat-value {
    color: #94a3b8;
    font-size: 0.75rem;
}

.modern-alert-card {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border: none;
    border-radius: 12px;
    color: white;
    margin-bottom: 2rem;
}

.modern-form-select {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
    padding-right: 2.25rem !important;
}

.modern-form-select:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
}

.modern-form-select option {
    background: #334155 !important;
    color: #e2e8f0 !important;
}

.modern-table-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    overflow: hidden;
}

.modern-table-header {
    background: #0f172a;
    border-bottom: 1px solid #334155;
    padding: 1.5rem;
    color: #f8fafc;
}

.modern-table {
    background: #1e293b;
    color: #e2e8f0;
    margin: 0;
}

.modern-table thead th {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-bottom: 1px solid #334155 !important;
    border-top: none !important;
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
    padding: 1rem !important;
}

.table-danger {
    background: rgba(220, 38, 38, 0.1) !important;
}

.table-warning {
    background: rgba(217, 119, 6, 0.1) !important;
}

.modern-btn-outline {
    background: transparent;
    border: 1px solid #475569;
    color: #e2e8f0;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
    font-size: 0.875rem;
}

.modern-btn-outline:hover {
    background: #334155;
    border-color: #3b82f6;
    color: #e2e8f0;
    text-decoration: none;
}

.modern-btn-danger {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    color: white;
}

.modern-btn-warning {
    background: linear-gradient(135deg, #d97706, #b45309);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.modern-btn-warning:hover {
    background: linear-gradient(135deg, #b45309, #92400e);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    color: white;
}

.modern-badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
}

.modern-badge.bg-danger {
    background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
}

.modern-badge.bg-warning {
    background: linear-gradient(135deg, #d97706, #b45309) !important;
}

.modern-badge.bg-info {
    background: linear-gradient(135deg, #0284c7, #0369a1) !important;
}

.modern-badge.bg-success {
    background: linear-gradient(135deg, #059669, #047857) !important;
}

.modern-badge.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
}

.modern-dropdown-menu {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
}

.modern-dropdown-item {
    color: #e2e8f0 !important;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.modern-dropdown-item:hover {
    background: #334155 !important;
    color: #f8fafc !important;
}

.modern-dropdown-divider {
    border-color: #334155 !important;
}

.modern-empty-state {
    padding: 4rem 2rem;
    text-align: center;
    color: #94a3b8;
}

.modern-empty-icon {
    font-size: 4rem;
    color: #059669;
    margin-bottom: 1rem;
}

.modern-filter-section {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .modern-filter-section {
        flex-direction: column;
        align-items: stretch;
    }
    
    .modern-filter-section .modern-form-select {
        width: 100% !important;
    }
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header with Filters -->
    <div class="modern-expiry-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-2">
                    <div class="modern-stat-icon stat-critical me-3">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Drug Expiry Alerts</h2>
                        <p class="mb-0" style="color: #94a3b8;">Monitor drug expiration dates and prevent stock losses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form method="GET" class="modern-filter-section justify-content-md-end">
                    <select name="days" class="modern-form-select" style="width: auto; min-width: 140px;" onchange="this.form.submit()">
                        <option value="30" {{ $filterDays == '30' ? 'selected' : '' }}>Next 30 Days</option>
                        <option value="60" {{ $filterDays == '60' ? 'selected' : '' }}>Next 60 Days</option>
                        <option value="90" {{ $filterDays == '90' ? 'selected' : '' }}>Next 90 Days</option>
                        <option value="180" {{ $filterDays == '180' ? 'selected' : '' }}>Next 6 Months</option>
                        <option value="365" {{ $filterDays == '365' ? 'selected' : '' }}>Next Year</option>
                    </select>
                    <select name="type" class="modern-form-select" style="width: auto; min-width: 120px;" onchange="this.form.submit()">
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

    <!-- Modern Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6">
            <div class="modern-stat-card">
                <div class="modern-stat-icon stat-expired">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="modern-stat-number">{{ $stats['expired_count'] }}</div>
                <div class="modern-stat-label">Expired</div>
                <div class="modern-stat-value">Rp {{ number_format($stats['total_expired_value'], 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="modern-stat-card">
                <div class="modern-stat-icon stat-critical">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="modern-stat-number">{{ $stats['critical_count'] }}</div>
                <div class="modern-stat-label">Critical (≤30 days)</div>
                <div class="modern-stat-value">Rp {{ number_format($stats['total_critical_value'], 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="modern-stat-card">
                <div class="modern-stat-icon stat-warning">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="modern-stat-number">{{ $stats['warning_count'] }}</div>
                <div class="modern-stat-label">Warning (≤90 days)</div>
                <div class="modern-stat-value">-</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="modern-stat-card">
                <div class="modern-stat-icon stat-notice">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div class="modern-stat-number">{{ $stats['notice_count'] }}</div>
                <div class="modern-stat-label">Notice (≤180 days)</div>
                <div class="modern-stat-value">-</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="modern-stat-card">
                <div class="modern-stat-icon stat-good">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="modern-stat-number">{{ $stats['good_count'] }}</div>
                <div class="modern-stat-label">Good (>180 days)</div>
                <div class="modern-stat-value">-</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="modern-stat-card">
                <div class="modern-stat-icon stat-total">
                    <i class="bi bi-capsule"></i>
                </div>
                <div class="modern-stat-number">{{ $stats['total_drugs'] }}</div>
                <div class="modern-stat-label">Total Active</div>
                <div class="modern-stat-value">-</div>
            </div>
        </div>
    </div>

    <!-- Modern Summary Alert -->
    @if($stats['total_at_risk_value'] > 0)
    <div class="modern-alert-card">
        <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-exclamation-triangle me-2"></i>Attention Required</h5>
            <p class="mb-3">
                <strong>{{ $stats['expired_count'] + $stats['critical_count'] + $stats['warning_count'] }}</strong> drugs require immediate attention.
                Total value at risk: <strong>Rp {{ number_format($stats['total_at_risk_value'], 0, ',', '.') }}</strong>
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="modern-btn-danger" onclick="generateReport()">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Generate Report
                </button>
                <button type="button" class="modern-btn-warning" onclick="markAllChecked()">
                    <i class="bi bi-check-all me-2"></i>Mark All as Reviewed
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modern Expiry Alerts Table -->
    <div class="modern-table-card">
        <div class="modern-table-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>Drug Expiry Details
            </h5>
            <span class="modern-badge bg-primary">{{ $expiryData->count() }} items</span>
        </div>
        <div class="p-0">
            @if($expiryData->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table table mb-0">
                        <thead>
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
                                    <span class="modern-badge {{ $badgeClass }}">
                                        {{ ucfirst($item['alert_level']) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">Rp {{ number_format($item['stock_value'], 0, ',', '.') }}</span>
                                    <br><small class="text-muted">@ Rp {{ number_format($item['drug']->harga_jual, 0, ',', '.') }}/unit</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="modern-btn-outline dropdown-toggle" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu modern-dropdown-menu">
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item" href="{{ route('drugs.show', $item['drug']->kd_obat) }}">
                                                    <i class="bi bi-eye me-2"></i>View Drug Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item" href="{{ route('drugs.edit', $item['drug']->kd_obat) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit Drug Info
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider modern-dropdown-divider"></li>
                                            <li>
                                                <button type="button" class="dropdown-item modern-dropdown-item" onclick="markAsChecked('{{ $item['drug']->kd_obat }}')">
                                                    <i class="bi bi-check-circle me-2"></i>Mark as Checked
                                                </button>
                                            </li>
                                            @if($item['is_expired'] || $item['alert_level'] == 'critical')
                                            <li>
                                                <button type="button" class="dropdown-item modern-dropdown-item" style="color: #d97706 !important;" onclick="createDiscountSale('{{ $item['drug']->kd_obat }}')">
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
                <div class="modern-empty-state">
                    <div class="modern-empty-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h5 style="color: #059669; margin-bottom: 1rem;">All Clear!</h5>
                    <p class="mb-3">No drugs matching your filter criteria require attention at this time.</p>
                    <a href="?days=365&type=all" class="modern-btn-outline">
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