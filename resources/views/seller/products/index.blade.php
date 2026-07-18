@extends('layouts.app')

@section('title', 'My Products — Seller')

@section('content')
<div class="page-header">
    <div>
        <h1>My Products</h1>
        <p class="text-muted">{{ $seller->shop_name }}</p>
    </div>
    <a href="/seller/products/create" class="btn btn-primary">+ Add Product</a>
</div>

@if(count($products) > 0)
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td><a href="/products/{{ $product->product_id }}">{{ $product->name }}</a></td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->brand_name }}</td>
                <td class="price price-sm">৳{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if($product->status === 'available')
                        <span class="badge badge-success">Available</span>
                    @else
                        <span class="badge badge-danger">Out of Stock</span>
                    @endif
                </td>
                <td>
                    <div class="actions">
                        <a href="/seller/products/{{ $product->product_id }}/edit" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="/seller/products/{{ $product->product_id }}" method="POST" class="inline-form" onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="empty-state">
    <h3>No products yet</h3>
    <p>Add your first product to start selling.</p>
    <a href="/seller/products/create" class="btn btn-primary mt-2">+ Add Product</a>
</div>
@endif
@endsection
