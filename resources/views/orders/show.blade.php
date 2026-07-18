@extends('layouts.app')

@section('title', 'Order #' . $order->order_id . ' — বেচাকেনা')

@section('content')
<div style="margin-bottom:1rem;">
    @if(session('role') === 'admin')
        <a href="/admin/orders" class="text-muted" style="font-size:0.9rem;">← Back to orders</a>
    @elseif(session('role') === 'seller')
        <a href="/seller/orders" class="text-muted" style="font-size:0.9rem;">← Back to orders</a>
    @else
        <a href="/orders" class="text-muted" style="font-size:0.9rem;">← Back to orders</a>
    @endif
</div>

<div class="page-header">
    <div>
        <h1>Order #{{ $order->order_id }}</h1>
        <p class="text-muted">Placed on {{ $order->order_date }}</p>
    </div>
    @php
        $statusBadge = match($order->status) {
            'pending'   => 'badge-warning',
            'paid'      => 'badge-info',
            'shipped'   => 'badge-primary',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-danger',
            default     => 'badge-info',
        };
    @endphp
    <span class="badge {{ $statusBadge }}" style="font-size:1rem;padding:0.5rem 1rem;">{{ ucfirst($order->status) }}</span>
</div>

<div class="card mb-3">
    <div class="card-header">Customer</div>
    <p><strong>{{ $order->customer_name }}</strong> ({{ $order->customer_email }})</p>
</div>

<div class="table-wrapper mb-3">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Shop</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td><a href="/products/{{ $item->product_id }}">{{ $item->product_name }}</a></td>
                <td>{{ $item->brand_name }}</td>
                <td>{{ $item->shop_name }}</td>
                <td>৳{{ number_format($item->price_at_purchase, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="price price-sm">৳{{ number_format($item->quantity * $item->price_at_purchase, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card" style="max-width:400px;margin-left:auto;">
    <div class="flex-between">
        <span style="font-size:1.1rem;font-weight:600;">Order Total</span>
        <span class="price" style="font-size:1.5rem;">৳{{ number_format($order->total, 2) }}</span>
    </div>
</div>

@if(session('role') === 'admin' || session('role') === 'seller')
<div class="card mt-3" style="max-width:400px;">
    <div class="card-header">Update Status</div>
    <form method="POST" action="{{ session('role') === 'admin' ? '/admin/orders/' . $order->order_id . '/status' : '/seller/orders/' . $order->order_id . '/status' }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <select name="status" class="form-control">
                @foreach(['pending', 'paid', 'shipped', 'delivered', 'cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update Status</button>
    </form>
</div>
@endif
@endsection
