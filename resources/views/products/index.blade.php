@extends('layouts.app')

@section('title', 'Products — বেচাকেনা')

@section('content')
<div class="page-header">
    <h1>Browse Products</h1>
    <span class="text-muted">{{ $totalCount }} product{{ $totalCount !== 1 ? 's' : '' }} found</span>
</div>

<!-- Filter Bar -->
<form method="GET" action="/products" class="filter-bar">
    <div class="form-group" style="flex:2;">
        <label class="form-label">Search</label>
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ $search }}">
    </div>
    <div class="form-group">
        <label class="form-label">Category</label>
        <select name="category" class="form-control">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->category_id }}" {{ $categoryId == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Brand</label>
        <select name="brand" class="form-control">
            <option value="">All Brands</option>
            @foreach($brands as $br)
                <option value="{{ $br->brand_id }}" {{ $brandId == $br->brand_id ? 'selected' : '' }}>{{ $br->brand_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Sort</label>
        <select name="sort" class="form-control">
            <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="price" {{ $sortBy === 'price' ? 'selected' : '' }}>Price ↑</option>
            <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Name A-Z</option>
        </select>
    </div>
    <input type="hidden" name="dir" value="{{ $sortBy === 'price' ? 'ASC' : ($sortBy === 'name' ? 'ASC' : 'DESC') }}">
    <div class="form-group" style="flex:0;">
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary">Filter</button>
    </div>
</form>

<!-- Product Grid -->
@if(count($products) > 0)
<div class="grid grid-4">
    @foreach($products as $product)
    <a href="/products/{{ $product->product_id }}" class="card" style="text-decoration:none;color:inherit;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.5rem;">
            <span class="badge badge-primary">{{ $product->category_name }}</span>
            @if($product->status === 'out_of_stock')
                <span class="badge badge-danger">Out of Stock</span>
            @else
                <span class="badge badge-success">Available</span>
            @endif
        </div>
        <h3 style="font-size:1rem;margin-bottom:0.3rem;">{{ $product->name }}</h3>
        <p class="text-muted" style="font-size:0.8rem;margin-bottom:0.5rem;">{{ $product->brand_name }} · {{ $product->shop_name }}</p>
        <div class="price">৳{{ number_format($product->price, 2) }}</div>
        <p class="text-muted" style="font-size:0.8rem;margin-top:0.3rem;">{{ $product->stock }} in stock</p>
    </a>
    @endforeach
</div>

<!-- Pagination -->
@if($totalPages > 1)
<div class="pagination">
    @if($page > 1)
        <a href="/products?{{ http_build_query(array_merge(request()->query(), ['page' => $page - 1])) }}">← Prev</a>
    @endif

    @for($i = 1; $i <= $totalPages; $i++)
        @if($i == $page)
            <span class="active"><span>{{ $i }}</span></span>
        @else
            <a href="/products?{{ http_build_query(array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
        @endif
    @endfor

    @if($page < $totalPages)
        <a href="/products?{{ http_build_query(array_merge(request()->query(), ['page' => $page + 1])) }}">Next →</a>
    @endif
</div>
@endif

@else
<div class="empty-state">
    <h3>No products found</h3>
    <p>Try adjusting your search or filter criteria.</p>
</div>
@endif
@endsection
