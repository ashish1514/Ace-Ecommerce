@extends('frontend.layouts.frontend')
@section('content')
<main>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Your Cart</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(count($cartItems) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                {{ $item['product']->name }}
                            </td>
                            <td>
                                ₹{{ number_format($item['product']->price, 2) }}
                            </td>
                            <td>
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 60px;">
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                </form>
                            </td>
                            <td>
                                ₹{{ number_format($item['product']->price * $item['quantity'], 2) }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>₹{{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="alert alert-info text-center">
                Your cart is empty.
            </div>
        @endif
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Continue Shopping</a>
    </div>
</main>
@endsection