@extends('frontend.layouts.frontend')
@section('content')
<style>
    .container { margin-top: 7%; }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Buy Now Checkout</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('buy.now.placeOrder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product</label>
                                <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price per unit</label>
                                <input type="text" class="form-control" value="${{ number_format($product->price, 2) }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Shipping Address</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="">Select a method</option>
                                    <option value="cod">Cash on Delivery</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
