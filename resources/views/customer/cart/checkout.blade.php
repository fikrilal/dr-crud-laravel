@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Customer / Cart /</span> Checkout
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-2"></i>Back to Cart
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('customer.order.place') }}">
        @csrf
        <div class="row">
            <!-- Order Details -->
            <div class="col-lg-8 mb-4">
                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Delivery Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="delivery_address">Delivery Address *</label>
                            <textarea class="form-control @error('delivery_address') is-invalid @enderror" 
                                      id="delivery_address" name="delivery_address" rows="3" 
                                      placeholder="Enter your complete delivery address..."
                                      required>{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>Delivery Information:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Free delivery for all orders</li>
                                <li>Delivery within 1-2 business days</li>
                                <li>Our pharmacist will contact you for prescription verification if needed</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check mb-3">
                                <input class="form-check-input @error('payment_method') is-invalid @enderror" 
                                       type="radio" name="payment_method" id="cash_on_delivery" 
                                       value="cash_on_delivery" {{ old('payment_method', 'cash_on_delivery') == 'cash_on_delivery' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cash_on_delivery">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-money text-success fs-4 me-3"></i>
                                        <div>
                                            <strong>Cash on Delivery (COD)</strong>
                                            <div class="text-muted small">Pay when you receive your order</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input @error('payment_method') is-invalid @enderror" 
                                       type="radio" name="payment_method" id="bank_transfer" 
                                       value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                <label class="form-check-label" for="bank_transfer">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-credit-card text-primary fs-4 me-3"></i>
                                        <div>
                                            <strong>Bank Transfer</strong>
                                            <div class="text-muted small">Transfer to our bank account (instructions will be sent)</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order Notes (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="notes">Special Instructions</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any special instructions for delivery or medication usage...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <!-- Cart Items -->
                        <div class="mb-3">
                            <h6 class="mb-3">Items ({{ count($cart) }})</h6>
                            @foreach($cart as $item)
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">{{ $item['name'] }}</div>
                                        <small class="text-muted">{{ $item['form'] }} × {{ $item['quantity'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-medium">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <!-- Totals -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery Fee</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax</span>
                            <span>Included</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check-circle me-2"></i>Place Order
                            </button>
                        </div>

                        <!-- Security Notice -->
                        <div class="alert alert-light mt-3" role="alert">
                            <i class="bx bx-shield-check text-success me-2"></i>
                            <small>
                                Your order is secure and will be processed by our licensed pharmacist.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection