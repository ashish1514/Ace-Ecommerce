@extends('frontend.layouts.frontend')
@section('content')
<style>
.container {margin-top: 7%;}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Buy Now Checkout</h4>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>Product:</strong> {{ $product['name'] }}
                    </div>

                    <div class="mb-3">
                        <strong>Price:</strong> ${{ number_format($product['price'], 2) }}
                    </div>

                    <div class="mb-4">
                        <strong>Quantity:</strong> {{ $product['quantity'] }}
                    </div>

                    <form action="{{ route('buy.now.placeOrder') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="">Select a method</option>
                                <!-- <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option> -->
                                <option value="cod">Cash on Delivery</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
