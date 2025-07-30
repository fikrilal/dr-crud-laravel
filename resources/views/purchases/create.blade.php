@extends('layouts.app')

@section('title', 'New Purchase Order')

@push('styles')
<style>
/* Modern Create Purchase Page Styles */
.modern-header {
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

.modern-form-control.is-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
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

.input-group-text {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #94a3b8 !important;
    border-radius: 8px 0 0 8px;
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

.modern-btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
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

.modern-btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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

.modern-btn-outline-danger {
    background: transparent;
    border: 1px solid #ef4444;
    color: #ef4444;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
}

.modern-btn-outline-danger:hover {
    background: #ef4444;
    color: white;
    text-decoration: none;
}

.modern-table {
    background: transparent !important;
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
    background: transparent !important;
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
    --bs-table-bg: transparent !important;
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

.modern-badge.bg-light {
    background: #475569 !important;
    color: #e2e8f0 !important;
}

.modern-badge.bg-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    color: white !important;
}

.empty-cart-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #475569, #64748b);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 2rem;
}

.drug-search-result {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    transition: all 0.2s ease;
}

.drug-search-result:hover {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}

.summary-card {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 1.5rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    color: #e2e8f0;
}

.summary-item:last-child {
    margin-bottom: 0;
    padding-top: 0.75rem;
    border-top: 1px solid #334155;
    font-weight: 600;
    font-size: 1.125rem;
}

.invalid-feedback {
    color: #ef4444 !important;
}

.alert-info {
    background: rgba(59, 130, 246, 0.1) !important;
    border: 1px solid rgba(59, 130, 246, 0.3) !important;
    color: #60a5fa !important;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1) !important;
    border: 1px solid rgba(239, 68, 68, 0.3) !important;
    color: #f87171 !important;
}

/* Custom input group styles for quantity controls */
.qty-control-group .btn {
    background: #475569 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    transition: all 0.2s ease;
}

.qty-control-group .btn:hover {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}

.qty-control-group .form-control {
    background: #334155 !important;
    border: 1px solid #475569 !important;
    color: #e2e8f0 !important;
    text-align: center;
}

.qty-control-group .form-control:focus {
    background: #334155 !important;
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
    box-shadow: none !important;
}
</style>
@endpush

@section('content')
<div class="p-4">
    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; margin-right: 1rem;">
                    <i class="bi bi-cart-plus"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="color: #f8fafc;">Create Purchase Order</h2>
                    <p class="mb-0" style="color: #94a3b8;">Add drugs and supplier information to create a new purchase order</p>
                </div>
            </div>
            <a href="{{ route('purchases.index') }}" class="modern-btn-outline">
                <i class="bi bi-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Drug Search & Cart -->
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>Drug Search & Purchase Items
                    </h5>
                </div>
                <div class="modern-card-body">
                    <!-- Drug Search -->
                    <div class="mb-4">
                        <label for="drugSearch" class="modern-form-label">Search Drugs</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-capsule"></i></span>
                            <input type="text" class="form-control modern-form-control" id="drugSearch" placeholder="Type drug name to search...">
                        </div>
                        <div id="drugSearchResults" class="mt-2"></div>
                    </div>

                    <!-- Purchase Cart -->
                    <div class="table-responsive">
                        <table class="modern-table table" id="purchaseTable">
                            <thead>
                                <tr>
                                    <th>Drug Name</th>
                                    <th width="10%">Current Stock</th>
                                    <th width="10%">Qty</th>
                                    <th width="15%">Unit Price</th>
                                    <th width="15%">Subtotal</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseItems">
                                <tr id="emptyPurchase">
                                    <td colspan="6" class="text-center py-4">
                                        <div class="empty-cart-icon mx-auto">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <h6 style="color: #f8fafc; margin-bottom: 0.5rem;">No items added</h6>
                                        <p style="color: #94a3b8; margin: 0; font-size: 0.875rem;">Search and add drugs above to build your purchase order</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Summary -->
                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="summary-card">
                                <div class="summary-item">
                                    <span style="color: #94a3b8;">Total Items:</span>
                                    <span id="totalItems" style="color: #f8fafc; font-weight: 600;">0</span>
                                </div>
                                <div class="summary-item">
                                    <span style="color: #94a3b8;">Total Amount:</span>
                                    <span id="totalAmount" style="color: #10b981; font-weight: 700; font-size: 1.25rem;">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Purchase Information -->
            <form id="purchaseForm" method="POST" action="{{ route('purchases.store') }}">
                @csrf
                <div class="modern-card mb-4">
                    <div class="modern-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-building me-2"></i>Supplier Information
                        </h5>
                    </div>
                    <div class="modern-card-body">
                        <div class="mb-3">
                            <label for="kd_supplier" class="modern-form-label">Supplier *</label>
                            <select class="form-select modern-form-control @error('kd_supplier') is-invalid @enderror" 
                                    id="kd_supplier" name="kd_supplier" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->kd_supplier }}" {{ old('kd_supplier') == $supplier->kd_supplier ? 'selected' : '' }}>
                                        {{ $supplier->nama_supplier }} - {{ $supplier->alamat_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kd_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tgl_nota" class="modern-form-label">Purchase Date *</label>
                            <input type="date" class="form-control modern-form-control @error('tgl_nota') is-invalid @enderror" 
                                   id="tgl_nota" name="tgl_nota" value="{{ old('tgl_nota', date('Y-m-d')) }}" required>
                            @error('tgl_nota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="modern-form-label">Notes</label>
                            <textarea class="form-control modern-form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" placeholder="Optional purchase notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="modern-btn-success btn-lg w-100" id="createPurchaseBtn" disabled>
                        <i class="bi bi-check-circle me-2"></i>Create Purchase Order
                    </button>
                    <a href="{{ route('purchases.index') }}" class="modern-btn-outline w-100 text-center">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let purchaseCart = [];
let drugSearchTimeout;

document.addEventListener('DOMContentLoaded', function() {
    initializeDrugSearch();
    initializeFormValidation();
    initializeFormSubmission();
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
                    resultsDiv.innerHTML = '<div class="alert alert-danger">Search failed. Please try again.</div>';
                });
        }, 300);
    });
}

function displaySearchResults(drugs) {
    const resultsDiv = document.getElementById('drugSearchResults');
    
    if (drugs.length === 0) {
        resultsDiv.innerHTML = '<div class="alert alert-info">No drugs found matching your search.</div>';
        return;
    }

    let html = '<div class="list-group">';
    drugs.forEach(drug => {
        html += `
            <div class="list-group-item drug-search-result" style="cursor: pointer; border-radius: 8px; margin-bottom: 0.5rem;" onclick="addToPurchase('${drug.id}', '${drug.nama_obat}', '${drug.bentuk_obat}', ${drug.stok})">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color: #f8fafc;">${drug.nama_obat}</h6>
                        <small style="color: #94a3b8;">${drug.bentuk_obat} - Current Stock: ${drug.stok}</small>
                    </div>
                    <div class="text-end">
                        <span class="modern-badge bg-info">Add to Purchase</span>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    resultsDiv.innerHTML = html;
}

function addToPurchase(drugId, drugName, drugForm, currentStock) {
    console.log(`🛒 Adding to purchase:`, {drugId, drugName, drugForm, currentStock});
    
    // Check if drug already in cart
    const existingIndex = purchaseCart.findIndex(item => item.drug_id === drugId);
    
    if (existingIndex !== -1) {
        console.log(`📦 Drug already in purchase cart at index ${existingIndex}`);
        alert('Drug already added to purchase order. You can edit the quantity and price below.');
        return;
    }

    // Add new item with default values
    const newItem = {
        drug_id: drugId,
        nama_obat: drugName,
        bentuk_obat: drugForm,
        current_stock: parseInt(currentStock),
        jumlah: 1,
        harga_satuan: 0.00
    };
    
    purchaseCart.push(newItem);
    console.log(`✅ Added new item to purchase:`, newItem);
    console.log(`📊 Purchase cart now has ${purchaseCart.length} items`);
    updatePurchaseDisplay();
    
    // Clear search
    document.getElementById('drugSearch').value = '';
    document.getElementById('drugSearchResults').innerHTML = '';
}

function updatePurchaseDisplay() {
    console.log(`🔄 Updating purchase display. Cart has ${purchaseCart.length} items:`, purchaseCart);
    
    const cartBody = document.getElementById('purchaseItems');
    const emptyPurchase = document.getElementById('emptyPurchase');
    
    // Clear existing rows except the empty cart row first
    const existingRows = cartBody.querySelectorAll('tr:not(#emptyPurchase)');
    existingRows.forEach(row => row.remove());
    
    if (purchaseCart.length === 0) {
        console.log('📝 Showing empty purchase message');
        emptyPurchase.style.display = 'table-row';
        updatePurchaseSummary();
        return;
    }
    
    console.log('📝 Hiding empty purchase message, displaying items');
    emptyPurchase.style.display = 'none';
    
    purchaseCart.forEach((item, index) => {
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
            <td><span class="modern-badge bg-light">${item.current_stock}</span></td>
            <td>
                <div class="input-group input-group-sm qty-control-group" style="min-width: 120px;">
                    <button class="btn decrease-btn" type="button" title="Decrease quantity" style="min-width: 30px;">-</button>
                    <input type="number" class="form-control text-center qty-input" min="1" max="10000" id="qty-${index}" style="min-width: 60px; padding: 0.25rem 0.1rem;">
                    <button class="btn increase-btn" type="button" title="Increase quantity" style="min-width: 30px;">+</button>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm modern-form-control price-input" step="0.01" min="0.01" placeholder="0.00" id="price-${index}">
            </td>
            <td>
                <span class="fw-bold subtotal-display" style="color: #10b981;">$${subtotal.toFixed(2)}</span>
            </td>
            <td>
                <button class="modern-btn-outline-danger btn-sm remove-btn" title="Remove item">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        
        // Add event listeners to the controls
        const decreaseBtn = row.querySelector('.decrease-btn');
        const increaseBtn = row.querySelector('.increase-btn');
        const removeBtn = row.querySelector('.remove-btn');
        const qtyInput = row.querySelector('.qty-input');
        const priceInput = row.querySelector('.price-input');
        
        // Set the current values
        qtyInput.value = item.jumlah;
        priceInput.value = item.harga_satuan;
        
        decreaseBtn.addEventListener('click', () => updateQuantity(index, -1));
        increaseBtn.addEventListener('click', () => updateQuantity(index, 1));
        removeBtn.addEventListener('click', () => removeFromPurchase(index));
        qtyInput.addEventListener('change', (e) => setQuantity(index, e.target.value));
        priceInput.addEventListener('change', (e) => setPrice(index, e.target.value));
        
        // Append the row to the cart body
        cartBody.appendChild(row);
    });
    
    updatePurchaseSummary();
}

function updateQuantity(index, change) {
    if (index < 0 || index >= purchaseCart.length) return;
    
    const item = purchaseCart[index];
    const newQty = item.jumlah + change;
    
    if (newQty >= 1 && newQty <= 10000) {
        purchaseCart[index].jumlah = newQty;
        updatePurchaseDisplay();
    }
}

function setQuantity(index, value) {
    if (index < 0 || index >= purchaseCart.length) return;
    
    const qty = parseInt(value);
    
    if (isNaN(qty)) {
        document.getElementById(`qty-${index}`).value = purchaseCart[index].jumlah;
        return;
    }
    
    if (qty >= 1 && qty <= 10000) {
        purchaseCart[index].jumlah = qty;
        updatePurchaseDisplay();
    } else {
        document.getElementById(`qty-${index}`).value = purchaseCart[index].jumlah;
    }
}

function setPrice(index, value) {
    if (index < 0 || index >= purchaseCart.length) return;
    
    const price = parseFloat(value);
    
    if (isNaN(price) || price < 0) {
        document.getElementById(`price-${index}`).value = purchaseCart[index].harga_satuan;
        return;
    }
    
    purchaseCart[index].harga_satuan = price;
    updatePurchaseDisplay();
}

function removeFromPurchase(index) {
    if (index < 0 || index >= purchaseCart.length) return;
    
    const removedItem = purchaseCart[index];
    purchaseCart.splice(index, 1);
    console.log(`✅ Removed item: ${removedItem.nama_obat}`);
    updatePurchaseDisplay();
}

function updatePurchaseSummary() {
    const totalItems = purchaseCart.reduce((sum, item) => sum + item.jumlah, 0);
    const totalAmount = purchaseCart.reduce((sum, item) => sum + (item.harga_satuan * item.jumlah), 0);
    
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalAmount').textContent = `$${totalAmount.toFixed(2)}`;
    
    // Enable/disable create button
    const createBtn = document.getElementById('createPurchaseBtn');
    const supplier = document.getElementById('kd_supplier').value;
    createBtn.disabled = purchaseCart.length === 0 || !supplier || !allItemsHavePrice();
}

function allItemsHavePrice() {
    return purchaseCart.every(item => item.harga_satuan > 0);
}

function initializeFormValidation() {
    document.getElementById('kd_supplier').addEventListener('change', updatePurchaseSummary);
}

function initializeFormSubmission() {
    document.getElementById('purchaseForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        if (purchaseCart.length === 0) {
            alert('Please add items to purchase order before creating.');
            return false;
        }
        
        const supplier = document.getElementById('kd_supplier').value;
        if (!supplier) {
            alert('Please select a supplier.');
            return false;
        }
        
        if (!allItemsHavePrice()) {
            alert('Please enter unit prices for all items.');
            return false;
        }
        
        const form = this;
        
        // Clear any previous hidden inputs
        form.querySelectorAll('input[name^="items["]').forEach(input => input.remove());
        
        // Add purchase items to form
        purchaseCart.forEach((item, index) => {
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
            
            const priceInput = document.createElement('input');
            priceInput.type = 'hidden';
            priceInput.name = `items[${index}][harga_satuan]`;
            priceInput.value = item.harga_satuan;
            form.appendChild(priceInput);
        });
        
        // Disable button to prevent double submission
        const button = document.getElementById('createPurchaseBtn');
        button.disabled = true;
        button.style.background = 'linear-gradient(135deg, #64748b, #475569)';
        button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating...';
        
        // Submit the form
        form.submit();
    });
}
</script>
@endpush