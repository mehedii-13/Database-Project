@extends('layouts.app')

@section('title', 'Edit Product — Seller')

@section('content')
<div class="auth-container" style="max-width:560px;">
    <div class="auth-card">
        <h2>Edit Product</h2>

        <form method="POST" action="/seller/products/{{ $product->product_id }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="grid grid-2" style="gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}" {{ old('category_id', $product->category_id) == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control" required>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->brand_id }}" {{ old('brand_id', $product->brand_id) == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-2" style="gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="price">Price (৳)</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Update Product</button>
        </form>
    </div>
</div>
@endsection
