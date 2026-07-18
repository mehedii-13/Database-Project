@extends('layouts.app')

@section('title', 'Shopping Cart — বেচাকেনা')

@section('content')
<div class="page-header">
    <h1>🛒 Shopping Cart</h1>
</div>

@if(count($items) > 0)
<div class="table-wrapper" style="margin-bottom:1.5rem;">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Shop</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><a href="/products/{{ $item->product_id }}">{{ $item->name }}</a></td>
                <td>{{ $item->brand_name }}</td>
                <td>{{ $item->shop_name }}</td>
                <td>৳{{ number_format($item->price, 2) }}</td>
                <td>
                    <form method="POST" action="/cart/update" style="display:flex;gap:0.5rem;align-items:center;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="cart_item_id" value="{{ $item->cart_item_id }}">
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->stock }}" class="form-control" style="width:70px;padding:0.4rem 0.5rem;">
                        <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                    </form>
                </td>
                <td class="price price-sm">৳{{ number_format($item->subtotal, 2) }}</td>
                <td>
                    <form action="/cart/remove/{{ $item->cart_item_id }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card" style="max-width:400px;margin-left:auto;">
    <div class="flex-between mb-2">
        <span style="font-size:1.1rem;font-weight:600;">Total</span>
        <span class="price" style="font-size:1.5rem;">৳{{ number_format($total, 2) }}</span>
    </div>
    <form method="POST" action="/orders/checkout">
        @csrf
        <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Place order for ৳{{ number_format($total, 2) }}?')">
            ✓ Place Order
        </button>
    </form>
</div>
@else
<div class="empty-state">
    <h3>Your cart is empty</h3>
    <p>Browse products and add something to your cart.</p>
    <a href="/products" class="btn btn-primary mt-2">Browse Products</a>
</div>
@endif
@endsection
