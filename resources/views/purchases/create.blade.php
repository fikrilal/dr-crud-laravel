@extends('layouts.app')

@section('title', 'New Purchase Order')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchase Orders</a></li>
        <li class="breadcrumb-item active">New Purchase Order</li>
    @endsection
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Drug Search & Cart -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>Drug Search & Purchase Items
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Drug Search -->
                    <div class="mb-4">
                        <label for="drugSearch" class="form-label">Search Drugs</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-capsule"></i></span>
                            <input type="text" class="form-control" id="drugSearch" placeholder="Type drug name to search...">
                        </div>
                        <div id="drugSearchResults" class="mt-2"></div>
                    </div>

                    <!-- Purchase Cart -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="purchaseTable">
                            <thead class="table-light">
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-cart display-1 mb-3"></i>
                                        <br>No items added. Search and add drugs above.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Summary -->
                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Items:</span>
                                        <span id="totalItems">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Total Amount:</span>
                                        <strong id="totalAmount">$0.00</strong>
                                    </div>
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
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-building me-2"></i>Supplier Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kd_supplier" class="form-label">Supplier *</label>
                            <select class="form-select @error('kd_supplier') is-invalid @enderror" 
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
                            <label for="tgl_nota" class="form-label">Purchase Date *</label>
                            <input type="date" class="form-control @error('tgl_nota') is-invalid @enderror" 
                                   id="tgl_nota" name="tgl_nota" value="{{ old('tgl_nota', date('Y-m-d')) }}" required>
                            @error('tgl_nota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" placeholder="Optional purchase notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg" id="createPurchaseBtn" disabled>
                        <i class="bi bi-check-circle me-2"></i>Create Purchase Order
                    </button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">
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
            <div class="list-group-item list-group-item-action" style="cursor: pointer;" onclick="addToPurchase('${drug.id}', '${drug.nama_obat}', '${drug.bentuk_obat}', ${drug.stok})">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${drug.nama_obat}</h6>
                        <small class="text-muted">${drug.bentuk_obat} - Current Stock: ${drug.stok}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-info">Add to Purchase</span>
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
                    <div class="fw-bold">${item.nama_obat}</div>
                    <small class="text-muted">${item.bentuk_obat}</small>
                </div>
            </td>
            <td><span class="badge bg-light text-dark">${item.current_stock}</span></td>
            <td>
                <div class="input-group input-group-sm" style="min-width: 120px;">
                    <button class="btn btn-outline-secondary decrease-btn" type="button" title="Decrease quantity" style="min-width: 30px;">-</button>
                    <input type="number" class="form-control text-center qty-input" min="1" max="10000" id="qty-${index}" style="min-width: 60px; padding: 0.25rem 0.1rem;">
                    <button class="btn btn-outline-secondary increase-btn" type="button" title="Increase quantity" style="min-width: 30px;">+</button>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm price-input" step="0.01" min="0.01" placeholder="0.00" id="price-${index}">
            </td>
            <td>
                <span class="fw-bold subtotal-display">$${subtotal.toFixed(2)}</span>
            </td>
            <td>
                <button class="btn btn-outline-danger btn-sm remove-btn" title="Remove item">
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
        button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating...';
        
        // Submit the form
        form.submit();
    });
}
</script>
@endpush