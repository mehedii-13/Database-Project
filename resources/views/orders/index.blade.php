@extends('layouts.app')

@section('title', 'My Orders — বেচাকেনা')

@section('content')
<div class="page-header">
    <h1>My Orders</h1>
</div>

@if(count($orders) > 0)
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->order_id }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->item_count }} item{{ $order->item_count > 1 ? 's' : '' }}</td>
                <td class="price price-sm">৳{{ number_format($order->total, 2) }}</td>
                <td>
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
                    <span class="badge {{ $statusBadge }}">{{ ucfirst($order->status) }}</span>
                </td>
                <td>
                    <a href="/orders/{{ $order->order_id }}" class="btn btn-secondary btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="empty-state">
    <h3>No orders yet</h3>
    <p>Start shopping to see your orders here.</p>
    <a href="/products" class="btn btn-primary mt-2">Browse Products</a>
</div>
@endif
@endsection
