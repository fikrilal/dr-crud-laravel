@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Customer /</span> Shopping Cart
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('customer.catalog.index') }}" class="btn btn-outline-primary">
                <i class="bx bx-arrow-back me-2"></i>Continue Shopping
            </a>
        </div>
    </div>

    @if(empty($cart))
        <!-- Empty Cart -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-cart display-1 text-muted mb-4"></i>
                <h4 class="mb-3">Your cart is empty</h4>
                <p class="text-muted mb-4">Add some medications to your cart to get started.</p>
                <a href="{{ route('customer.catalog.index') }}" class="btn btn-primary">
                    <i class="bx bx-search me-2"></i>Browse Catalog
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Cart Items ({{ count($cart) }})</h5>
                        <small class="text-muted">Total: Rp {{ number_format($total, 0, ',', '.') }}</small>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cart as $drugId => $item)
                            <div class="cart-item border-bottom p-4" data-drug-id="{{ $drugId }}">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                                        <small class="text-muted">{{ $item['form'] }}</small>
                                        <div class="mt-1">
                                            <span class="badge bg-label-primary">{{ $item['form'] }}</span>
                                            <small class="text-muted ms-2">Max: {{ $item['max_stock'] }} available</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <strong class="text-primary">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </strong>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm">
                                            <button type="button" class="btn btn-outline-secondary decrease-btn" 
                                                    data-drug-id="{{ $drugId }}">
                                                <i class="bx bx-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center quantity-input" 
                                                   value="{{ $item['quantity'] }}" min="1" max="{{ min(10, $item['max_stock']) }}"
                                                   data-drug-id="{{ $drugId }}" readonly>
                                            <button type="button" class="btn btn-outline-secondary increase-btn"
                                                    data-drug-id="{{ $drugId }}">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn"
                                                data-drug-id="{{ $drugId }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6 text-end">
                                        <strong class="item-total">
                                            Subtotal: Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Items ({{ count($cart) }})</span>
                            <span id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery</span>
                            <span class="text-success">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-primary" id="final-total">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.checkout') }}" class="btn btn-primary">
                                <i class="bx bx-credit-card me-2"></i>Proceed to Checkout
                            </a>
                            <button type="button" class="btn btn-outline-secondary" onclick="clearCart()">
                                <i class="bx bx-trash me-2"></i>Clear Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bx bx-truck text-primary me-2"></i>Delivery Information
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bx bx-check text-success me-2"></i>
                                Free delivery for all orders
                            </li>
                            <li class="mb-2">
                                <i class="bx bx-time text-info me-2"></i>
                                Delivery within 1-2 business days
                            </li>
                            <li>
                                <i class="bx bx-shield text-warning me-2"></i>
                                Licensed pharmacist review included
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity increase/decrease buttons
    document.querySelectorAll('.increase-btn, .decrease-btn').forEach(button => {
        button.addEventListener('click', function() {
            const drugId = this.dataset.drugId;
            const quantityInput = document.querySelector(`input[data-drug-id="${drugId}"]`);
            const isIncrease = this.classList.contains('increase-btn');
            
            let newQuantity = parseInt(quantityInput.value);
            if (isIncrease) {
                newQuantity = Math.min(newQuantity + 1, parseInt(quantityInput.max));
            } else {
                newQuantity = Math.max(newQuantity - 1, 1);
            }
            
            if (newQuantity !== parseInt(quantityInput.value)) {
                updateCartQuantity(drugId, newQuantity);
            }
        });
    });

    // Remove buttons
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const drugId = this.dataset.drugId;
            removeFromCart(drugId);
        });
    });
});

function updateCartQuantity(drugId, quantity) {
    const formData = new FormData();
    formData.append('drug_id', drugId);
    formData.append('quantity', quantity);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch('{{ route("customer.cart.update") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update quantity input
            document.querySelector(`input[data-drug-id="${drugId}"]`).value = quantity;
            
            // Update item total
            const cartItem = document.querySelector(`div[data-drug-id="${drugId}"]`);
            cartItem.querySelector('.item-total').textContent = `Subtotal: Rp ${data.item_total}`;
            
            // Update overall total
            document.getElementById('cart-total').textContent = `Rp ${data.total}`;
            document.getElementById('final-total').textContent = `Rp ${data.total}`;
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while updating cart.');
    });
}

function removeFromCart(drugId) {
    if (!confirm('Remove this item from cart?')) return;

    const formData = new FormData();
    formData.append('drug_id', drugId);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch('{{ route("customer.cart.remove") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            document.querySelector(`div[data-drug-id="${drugId}"]`).remove();
            
            // Update totals
            document.getElementById('cart-total').textContent = `Rp ${data.total}`;
            document.getElementById('final-total').textContent = `Rp ${data.total}`;
            
            // If cart is empty, reload page
            if (data.cart_count === 0) {
                location.reload();
            }
            
            showAlert('success', data.message);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while removing item.');
    });
}

function clearCart() {
    if (!confirm('Clear all items from cart?')) return;
    
    // Remove all items one by one (could be optimized with a dedicated endpoint)
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.click();
    });
}

function showAlert(type, message) {
    const existingAlert = document.querySelector('.cart-alert');
    if (existingAlert) existingAlert.remove();
    
    const alertType = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'bx-check-circle' : 'bx-error';
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertType} alert-dismissible fade show cart-alert`;
    alertDiv.innerHTML = `
        <i class="bx ${icon} me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.querySelector('.container-xxl').prepend(alertDiv);
    
    setTimeout(() => {
        if (alertDiv) alertDiv.remove();
    }, 3000);
}
</script>
@endsection