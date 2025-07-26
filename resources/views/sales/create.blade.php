@extends('layouts.app')

@section('title', 'New Sale Transaction')

@section('header')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales History</a></li>
        <li class="breadcrumb-item active">New Sale</li>
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
                        <i class="bi bi-search me-2"></i>Drug Search & Cart
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

                    <!-- Shopping Cart -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="cartTable">
                            <thead class="table-light">
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-cart display-1 mb-3"></i>
                                        <br>Cart is empty. Search and add drugs above.
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
            <!-- Customer & Payment -->
                            <form id="saleForm" method="POST" action="{{ route('sales.store') }}">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>Customer Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option value="">Walk-in Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->nama_pelanggan }} - {{ $customer->nomor_telepon }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                            <i class="bi bi-plus me-2"></i>Add New Customer
                        </button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-credit-card me-2"></i>Payment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
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

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg" id="processSaleBtn" disabled>
                        <i class="bi bi-check-circle me-2"></i>Process Sale
                    </button>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- New Customer Modal -->
<div class="modal fade" id="newCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newCustomerForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_pelanggan" class="form-label">Customer Name *</label>
                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label">Phone Number *</label>
                        <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Address</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
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
            <div class="list-group-item list-group-item-action" style="cursor: pointer;" onclick="addToCart('${drug.id}', '${drug.nama_obat}', ${drug.harga_jual}, ${drug.stok}, '${drug.bentuk_obat}')">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${drug.nama_obat}</h6>
                        <small class="text-muted">${drug.bentuk_obat} - Stock: ${drug.stok}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">$${drug.harga_jual}</span>
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
                    <div class="fw-bold">${item.nama_obat}</div>
                    <small class="text-muted">${item.bentuk_obat}</small>
                </div>
            </td>
            <td><span class="badge bg-light text-dark">${item.stok}</span></td>
            <td>
                <div class="input-group input-group-sm" style="min-width: 120px;">
                    <button class="btn btn-outline-secondary decrease-btn" type="button" title="Decrease quantity" style="min-width: 30px;">-</button>
                    <input type="number" class="form-control text-center qty-input" min="1" max="${item.stok}" id="qty-${index}" style="min-width: 60px; padding: 0.25rem 0.1rem;">
                    <button class="btn btn-outline-secondary increase-btn" type="button" title="Increase quantity" style="min-width: 30px;">+</button>
                </div>
            </td>
            <td>$${item.harga_satuan.toFixed(2)}</td>
            <td>$${subtotal.toFixed(2)}</td>
            <td>
                <button class="btn btn-outline-danger btn-sm remove-btn" title="Remove item">
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