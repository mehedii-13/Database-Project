@extends('layouts.app')

@section('title', 'Orders — Seller')

@section('content')
<div class="page-header">
    <h1>Orders for My Products</h1>
</div>

@if(count($orders) > 0)
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Date</th>
                <th>My Revenue</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->order_id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->order_date }}</td>
                <td class="price price-sm">৳{{ number_format($order->seller_total ?? 0, 2) }}</td>
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
    <p>Orders containing your products will appear here.</p>
</div>
@endif
@endsection
