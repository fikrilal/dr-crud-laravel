@extends('layouts.app')

@section('title', 'New Sale Transaction')

@push('styles')
<style>
/* Modern Sales Processing Page Styles */
.modern-sales-header {
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
    padding: 2rem;
    color: #e2e8f0;
}

.modern-form-control {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
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

.modern-form-label {
    color: #f8fafc;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.modern-form-select {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
    padding: 0.75rem 1rem;
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

/* Fix Bootstrap form-select specifically */
.form-select {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
    padding-right: 2.25rem !important;
}

.form-select:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
}

.form-select option {
    background: #334155 !important;
    color: #e2e8f0 !important;
}

.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #94a3b8 !important;
    border-radius: 8px 0 0 8px;
}

.modern-search-results {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
    margin-top: 0.5rem;
    max-height: 300px;
    overflow-y: auto;
}

.modern-search-item {
    background: transparent !important;
    border: none !important;
    border-bottom: 1px solid #334155 !important;
    color: #e2e8f0 !important;
    padding: 1rem;
    transition: all 0.2s ease;
}

.modern-search-item:hover {
    background: #334155 !important;
    color: #f8fafc !important;
}

.modern-search-item:last-child {
    border-bottom: none !important;
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
}

/* Force override any Bootstrap table styles */
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

.table > thead {
    background-color: #0f172a !important;
}

.table > thead th {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
}

.table-hover > tbody > tr:hover > * {
    background-color: var(--bs-table-hover-bg) !important;
    color: var(--bs-table-hover-color) !important;
}

.modern-empty-cart {
    color: #94a3b8;
    text-align: center;
    padding: 3rem 1rem;
}

.modern-empty-icon {
    font-size: 3rem;
    color: #475569;
    margin-bottom: 1rem;
}

.modern-cart-summary {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
    color: #e2e8f0;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: white;
}

.modern-btn-primary:disabled {
    background: #475569;
    transform: none;
    box-shadow: none;
    cursor: not-allowed;
}

.modern-btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    font-size: 1.1rem;
}

.modern-btn-success:hover:not(:disabled) {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
}

.modern-btn-success:disabled {
    background: #475569;
    transform: none;
    box-shadow: none;
    cursor: not-allowed;
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
    justify-content: center;
}

.modern-btn-outline:hover {
    background: #334155;
    border-color: #3b82f6;
    color: #e2e8f0;
    text-decoration: none;
}

.modern-btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.modern-btn-danger {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border: none;
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    color: white;
}

.modern-input-group {
    display: flex;
    border-radius: 8px;
    overflow: hidden;
}

.modern-input-group .form-control {
    border-radius: 0 8px 8px 0;
    border-left: none;
}

.modern-badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
}

.modern-badge.bg-light {
    background: #475569 !important;
    color: #e2e8f0 !important;
}

.modern-badge.bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    color: white !important;
}

.modern-modal-content {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    border-radius: 16px;
    color: #e2e8f0;
}

.modern-modal-header {
    background: #0f172a;
    border-bottom: 1px solid #334155 !important;
    border-radius: 16px 16px 0 0;
    color: #f8fafc;
}

.modern-modal-body {
    background: #1e293b;
    color: #e2e8f0;
}

.modern-modal-footer {
    background: #0f172a;
    border-top: 1px solid #334155 !important;
    border-radius: 0 0 16px 16px;
}

.btn-close {
    filter: invert(1);
    opacity: 0.6;
}

.btn-close:hover {
    opacity: 1;
}

.modern-quantity-controls {
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    min-width: 120px;
}

.modern-quantity-btn {
    background: #475569;
    border: 1px solid #475569;
    color: #e2e8f0;
    padding: 0.25rem 0.5rem;
    min-width: 30px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modern-quantity-btn:hover {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.modern-quantity-input {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    text-align: center;
    min-width: 60px;
    padding: 0.25rem 0.1rem;
    border-left: none !important;
    border-right: none !important;
}

.modern-quantity-input:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: none !important;
}

@media (max-width: 768px) {
    .modern-card-body {
        padding: 1rem;
    }
    
    .modern-sales-header {
        padding: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Sales Header -->
    <div class="modern-sales-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="modern-card-icon me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white;">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">New Sale Transaction</h2>
                    <p class="mb-0" style="color: #94a3b8;">Process customer sales and manage inventory</p>
                </div>
            </div>
            <a href="{{ route('sales.index') }}" class="modern-btn-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Sales
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Modern Drug Search & Cart -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>Drug Search & Cart
                    </h5>
                </div>
                <div class="modern-card-body">
                    <!-- Modern Drug Search -->
                    <div class="mb-4">
                        <label for="drugSearch" class="modern-form-label">Search Drugs</label>
                        <div class="modern-input-group">
                            <span class="input-group-text"><i class="bi bi-capsule"></i></span>
                            <input type="text" class="modern-form-control" id="drugSearch" placeholder="Type drug name to search...">
                        </div>
                        <div id="drugSearchResults" class="mt-2"></div>
                    </div>

                    <!-- Modern Shopping Cart -->
                    <div class="table-responsive">
                        <table class="modern-table table" id="cartTable">
                            <thead>
                                <tr>
                                    <th>Drug Name</th>
                                    <th width="10%">Stock</th>
                                    <th width="10%">Qty</th>
                                    <th width="15%">Unit Price</th>
                                    <th width="15%">Subtotal</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                <tr id="emptyCart">
                                    <td colspan="6" class="modern-empty-cart">
                                        <div class="modern-empty-icon">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div>Cart is empty. Search and add drugs above.</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modern Cart Summary -->
                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="modern-cart-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Items:</span>
                                    <span id="totalItems">0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Total Amount:</span>
                                    <strong id="totalAmount" style="color: #10b981; font-size: 1.1rem;">$0.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Modern Customer & Payment -->
            <form id="saleForm" method="POST" action="{{ route('sales.store') }}">
                @csrf
                <div class="modern-card">
                    <div class="modern-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>Customer Information
                        </h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="mb-3">
                            <label for="customer_id" class="modern-form-label">Customer</label>
                            <select class="modern-form-select" id="customer_id" name="customer_id">
                                <option value="">Walk-in Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->nama_pelanggan }} - {{ $customer->nomor_telepon }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="button" class="modern-btn-primary modern-btn-sm w-100" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                            <i class="bi bi-plus me-2"></i>Add New Customer
                        </button>
                    </div>
                </div>

                <div class="modern-card">
                    <div class="modern-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-credit-card me-2"></i>Payment Method
                        </h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="mb-3">
                            <select class="modern-form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="transfer">Bank Transfer</option>
                                <option value="insurance">Insurance</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Modern Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="modern-btn-success" id="processSaleBtn" disabled style="padding: 1rem;">
                        <i class="bi bi-check-circle me-2"></i>Process Sale
                    </button>
                    <a href="{{ route('sales.index') }}" class="modern-btn-outline" style="text-align: center;">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modern New Customer Modal -->
<div class="modal fade" id="newCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modern-modal-content">
            <div class="modal-header modern-modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newCustomerForm">
                <div class="modal-body modern-modal-body">
                    <div class="mb-3">
                        <label for="nama_pelanggan" class="modern-form-label">Customer Name *</label>
                        <input type="text" class="modern-form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_telepon" class="modern-form-label">Phone Number *</label>
                        <input type="text" class="modern-form-control" id="nomor_telepon" name="nomor_telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="modern-form-label">Address</label>
                        <textarea class="modern-form-control" id="alamat" name="alamat" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="modern-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="modern-btn-primary">Add Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let drugSearchTimeout;

document.addEventListener('DOMContentLoaded', function() {
    initializeDrugSearch();
    initializeFormValidation();
    initializeFormSubmission();
    initializeNewCustomerForm();
});

function initializeDrugSearch() {
    const searchInput = document.getElementById('drugSearch');
    const resultsDiv = document.getElementById('drugSearchResults');

    searchInput.addEventListener('input', function() {
        clearTimeout(drugSearchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            resultsDiv.innerHTML = '';
            return;
        }

        drugSearchTimeout = setTimeout(() => {
            fetch(`/api/drugs/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(drugs => {
                    displaySearchResults(drugs);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsDiv.innerHTML = '<div style="padding: 1rem; color: #f87171; text-align: center; background: rgba(220, 38, 38, 0.1); border: 1px solid #dc2626; border-radius: 8px;">Search failed. Please try again.</div>';
                });
        }, 300);
    });
}

function displaySearchResults(drugs) {
    const resultsDiv = document.getElementById('drugSearchResults');
    
    if (drugs.length === 0) {
        resultsDiv.innerHTML = '<div style="padding: 1rem; color: #94a3b8; text-align: center; background: #1e293b; border: 1px solid #334155; border-radius: 8px;">No drugs found matching your search.</div>';
        return;
    }

    let html = '<div class="modern-search-results">';
    drugs.forEach(drug => {
        html += `
            <div class="modern-search-item" style="cursor: pointer;" onclick="addToCart('${drug.id}', '${drug.nama_obat}', ${drug.harga_jual}, ${drug.stok}, '${drug.bentuk_obat}')">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color: #f8fafc;">${drug.nama_obat}</h6>
                        <small style="color: #94a3b8;">${drug.bentuk_obat} - Stock: ${drug.stok}</small>
                    </div>
                    <div class="text-end">
                        <span class="modern-badge bg-primary">$${drug.harga_jual}</span>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    resultsDiv.innerHTML = html;
}

function addToCart(drugId, drugName, price, stock, form) {
    console.log(`🛒 Adding to cart:`, {drugId, drugName, price, stock, form});
    
    // Check if drug already in cart
    const existingIndex = cart.findIndex(item => item.drug_id === drugId);
    
    if (existingIndex !== -1) {
        console.log(`📦 Drug already in cart at index ${existingIndex}`);
        // Increase quantity
        if (cart[existingIndex].jumlah < stock) {
            cart[existingIndex].jumlah++;
            console.log(`✅ Increased quantity to ${cart[existingIndex].jumlah}`);
            updateCartDisplay();
        } else {
            console.log(`❌ Cannot add more. Stock limit reached: ${stock}`);
            alert('Cannot add more. Stock limit reached.');
        }
    } else {
        // Add new item
        const newItem = {
            drug_id: drugId,
            nama_obat: drugName,
            harga_satuan: parseFloat(price),
            stok: parseInt(stock),
            bentuk_obat: form,
            jumlah: 1
        };
        
        cart.push(newItem);
        console.log(`✅ Added new item to cart:`, newItem);
        console.log(`📊 Cart now has ${cart.length} items`);
        updateCartDisplay();
    }
    
    // Clear search
    document.getElementById('drugSearch').value = '';
    document.getElementById('drugSearchResults').innerHTML = '';
}

function updateCartDisplay() {
    console.log(`🔄 Updating cart display. Cart has ${cart.length} items:`, cart);
    
    const cartBody = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');
    
    // Clear existing rows except the empty cart row first
    const existingRows = cartBody.querySelectorAll('tr:not(#emptyCart)');
    existingRows.forEach(row => row.remove());
    
    if (cart.length === 0) {
        console.log('📝 Showing empty cart message');
        emptyCart.style.display = 'table-row';
        updateCartSummary();
        return;
    }
    
    console.log('📝 Hiding empty cart message, displaying items');
    emptyCart.style.display = 'none';
    
    cart.forEach((item, index) => {
        const subtotal = item.harga_satuan * item.jumlah;
        
        // Create new row element
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <div>
                    <div class="fw-bold" style="color: #f8fafc;">${item.nama_obat}</div>
                    <small style="color: #94a3b8;">${item.bentuk_obat}</small>
                </div>
            </td>
            <td><span class="modern-badge bg-light">${item.stok}</span></td>
            <td>
                <div class="modern-quantity-controls">
                    <button class="modern-quantity-btn decrease-btn" type="button" title="Decrease quantity">-</button>
                    <input type="number" class="modern-quantity-input qty-input" min="1" max="${item.stok}" id="qty-${index}">
                    <button class="modern-quantity-btn increase-btn" type="button" title="Increase quantity">+</button>
                </div>
            </td>
            <td style="color: #e2e8f0;">$${item.harga_satuan.toFixed(2)}</td>
            <td style="color: #10b981; font-weight: 600;">$${subtotal.toFixed(2)}</td>
            <td>
                <button class="modern-btn-danger remove-btn" title="Remove item">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        
        // Add event listeners to the buttons and set input value
        const decreaseBtn = row.querySelector('.decrease-btn');
        const increaseBtn = row.querySelector('.increase-btn');
        const removeBtn = row.querySelector('.remove-btn');
        const qtyInput = row.querySelector('.qty-input');
        
        // Set the quantity value after creating the element
        qtyInput.value = item.jumlah;
        
        decreaseBtn.addEventListener('click', () => updateQuantity(index, -1));
        increaseBtn.addEventListener('click', () => updateQuantity(index, 1));
        removeBtn.addEventListener('click', () => removeFromCart(index));
        qtyInput.addEventListener('change', (e) => setQuantity(index, e.target.value));
        
        // Append the row to the cart body
        cartBody.appendChild(row);
    });
    updateCartSummary();
}

function updateQuantity(index, change) {
    console.log(`🔄 Updating quantity for item ${index}, change: ${change}`);
    
    if (index < 0 || index >= cart.length) {
        console.error('❌ Invalid cart index:', index);
        return;
    }
    
    const item = cart[index];
    const newQty = item.jumlah + change;
    
    console.log(`Current qty: ${item.jumlah}, New qty: ${newQty}, Stock: ${item.stok}`);
    
    if (newQty >= 1 && newQty <= item.stok) {
        cart[index].jumlah = newQty;
        console.log(`✅ Quantity updated to ${newQty}`);
        updateCartDisplay();
    } else {
        console.log(`❌ Quantity ${newQty} is out of range (1-${item.stok})`);
        if (newQty > item.stok) {
            alert(`Cannot exceed stock limit of ${item.stok}`);
        }
    }
}

function setQuantity(index, value) {
    console.log(`📝 Setting quantity for item ${index} to: ${value}`);
    
    if (index < 0 || index >= cart.length) {
        console.error('❌ Invalid cart index:', index);
        return;
    }
    
    const qty = parseInt(value);
    const item = cart[index];
    
    if (isNaN(qty)) {
        console.log('❌ Invalid quantity value, resetting to current');
        document.getElementById(`qty-${index}`).value = item.jumlah;
        return;
    }
    
    if (qty >= 1 && qty <= item.stok) {
        cart[index].jumlah = qty;
        console.log(`✅ Quantity set to ${qty}`);
        updateCartDisplay();
    } else {
        console.log(`❌ Quantity ${qty} is out of range (1-${item.stok}), resetting`);
        document.getElementById(`qty-${index}`).value = item.jumlah;
        if (qty > item.stok) {
            alert(`Cannot exceed stock limit of ${item.stok}`);
        }
    }
}

function removeFromCart(index) {
    console.log(`🗑️ Removing item ${index} from cart`);
    
    if (index < 0 || index >= cart.length) {
        console.error('❌ Invalid cart index:', index);
        return;
    }
    
    const removedItem = cart[index];
    cart.splice(index, 1);
    console.log(`✅ Removed item: ${removedItem.nama_obat}`);
    updateCartDisplay();
}

function updateCartSummary() {
    const totalItems = cart.reduce((sum, item) => sum + item.jumlah, 0);
    const totalAmount = cart.reduce((sum, item) => sum + (item.harga_satuan * item.jumlah), 0);
    
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalAmount').textContent = `$${totalAmount.toFixed(2)}`;
    
    // Enable/disable process button
    const processBtn = document.getElementById('processSaleBtn');
    const paymentMethod = document.getElementById('metode_pembayaran').value;
    processBtn.disabled = cart.length === 0 || !paymentMethod;
}

function initializeFormValidation() {
    document.getElementById('metode_pembayaran').addEventListener('change', updateCartSummary);
}

function initializeFormSubmission() {
    document.getElementById('saleForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Send log to Laravel for debugging
    fetch('/api/debug-log', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            message: 'SALE PROCESSING STARTED',
            cart: cart,
            timestamp: new Date().toISOString()
        })
    }).catch(e => console.log('Log failed:', e));
    
    console.log('=== SALE PROCESSING STARTED ===');
    console.log('Cart contents:', cart);
    alert('DEBUG: Form submitted. Cart items: ' + cart.length + ', Check console with "Preserve log" enabled');
    
    if (cart.length === 0) {
        alert('Please add items to cart before processing sale.');
        console.log('❌ Form submission stopped: Cart is empty');
        return false;
    }
    
    const paymentMethod = document.getElementById('metode_pembayaran').value;
    console.log('Payment method:', paymentMethod);
    alert('DEBUG: Payment method: ' + paymentMethod);
    
    if (!paymentMethod) {
        alert('Please select a payment method.');
        console.log('❌ Form submission stopped: No payment method selected');
        return false;
    }
    
    console.log('✅ Validation passed. Preparing form data...');
    alert('DEBUG: About to submit form with ' + cart.length + ' items');
    
    const form = this;
    
    // Clear any previous hidden inputs
    form.querySelectorAll('input[name^="items["]').forEach(input => input.remove());
    
    // Add cart items to form
    cart.forEach((item, index) => {
        const drugInput = document.createElement('input');
        drugInput.type = 'hidden';
        drugInput.name = `items[${index}][drug_id]`;
        drugInput.value = item.drug_id;
        form.appendChild(drugInput);
        
        const qtyInput = document.createElement('input');
        qtyInput.type = 'hidden';
        qtyInput.name = `items[${index}][jumlah]`;
        qtyInput.value = item.jumlah;
        form.appendChild(qtyInput);
        
        console.log(`✅ Added item ${index}:`, {
            drug_id: item.drug_id,
            jumlah: item.jumlah
        });
    });
    
    console.log('🚀 Submitting form now...');
    
    // Disable button to prevent double submission
    const button = document.getElementById('processSaleBtn');
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
    
    // Submit the form normally
    form.submit();
    });
}

function initializeNewCustomerForm() {
    document.getElementById('newCustomerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/api/sales/customer', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add to customer select
                const select = document.getElementById('customer_id');
                const option = new Option(
                    `${data.customer.nama_pelanggan} - ${data.customer.nomor_telepon}`,
                    data.customer.id,
                    true,
                    true
                );
                select.add(option);
                
                // Close modal and reset form
                bootstrap.Modal.getInstance(document.getElementById('newCustomerModal')).hide();
                this.reset();
                
                alert('Customer added successfully!');
            } else {
                alert('Failed to add customer: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add customer. Please try again.');
        });
    });
}
</script>
@endpush 