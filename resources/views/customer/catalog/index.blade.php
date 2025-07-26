@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Customer /</span> Drug Catalog
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <div class="badge bg-primary fs-6">{{ $drugs->total() }} drugs available</div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('customer.catalog.index') }}" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label">Search Drugs</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-search-alt"></i></span>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" placeholder="Search by name, category...">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div class="col-md-2">
                    <label class="form-label">Min Price</label>
                    <input type="number" class="form-control" name="min_price" 
                           value="{{ request('min_price') }}" placeholder="0" min="0" step="0.01">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Max Price</label>
                    <input type="number" class="form-control" name="max_price" 
                           value="{{ request('max_price') }}" placeholder="1000" min="0" step="0.01">
                </div>

                <!-- Actions -->
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-search-alt"></i>
                    </button>
                    <a href="{{ route('customer.catalog.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-refresh"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sort and View Options -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-sort"></i> Sort by: 
                    @switch(request('sort'))
                        @case('price_low') Price: Low to High @break
                        @case('price_high') Price: High to Low @break
                        @case('newest') Newest First @break
                        @default Name (A-Z)
                    @endswitch
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}">
                        Name (A-Z)</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">
                        Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">
                        Price: High to Low</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                        Newest First</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <small class="text-muted">
                Showing {{ $drugs->firstItem() }} to {{ $drugs->lastItem() }} of {{ $drugs->total() }} results
            </small>
        </div>
    </div>

    <!-- Products Grid -->
    @if($drugs->count() > 0)
        <div class="row">
            @foreach($drugs as $drug)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 drug-card">
                        <div class="card-body">
                            <!-- Stock Badge -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-label-{{ $drug->isLowStock() ? 'warning' : 'success' }}">
                                    {{ $drug->stok }} in stock
                                </span>
                                @if($drug->isLowStock())
                                    <span class="badge bg-label-warning">Low Stock</span>
                                @endif
                            </div>

                            <!-- Drug Name -->
                            <h5 class="card-title mb-2">
                                <a href="{{ route('customer.catalog.show', $drug->kd_obat) }}" 
                                   class="text-decoration-none">
                                    {{ $drug->nm_obat }}
                                </a>
                            </h5>

                            <!-- Category and Form -->
                            <div class="mb-2">
                                <span class="badge bg-label-primary">{{ ucfirst($drug->jenis) }}</span>
                                <span class="badge bg-label-secondary">{{ $drug->satuan }}</span>
                            </div>

                            <!-- Description -->
                            @if($drug->description)
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($drug->description, 80) }}
                                </p>
                            @endif

                            <!-- Supplier -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bx bx-store"></i> {{ $drug->supplier->nm_supplier ?? 'N/A' }}
                                </small>
                            </div>

                            <!-- Price -->
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-primary">
                                    Rp {{ number_format($drug->harga_jual, 0, ',', '.') }}
                                </h5>
                                <a href="{{ route('customer.catalog.show', $drug->kd_obat) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $drugs->withQueryString()->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-package display-1 text-muted mb-4"></i>
                <h4 class="mb-3">No drugs found</h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                        No drugs match your current filters. Try adjusting your search criteria.
                    @else
                        No drugs are currently available in our catalog.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                    <a href="{{ route('customer.catalog.index') }}" class="btn btn-primary">
                        <i class="bx bx-refresh me-2"></i>Clear Filters
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<style>
.drug-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e6e9ed;
}

.drug-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
}

.card-title a {
    color: inherit;
}

.card-title a:hover {
    color: #696cff !important;
}
</style>
@endsection