@extends('layouts.app')

@section('title', 'Add Product — Seller')

@section('content')
<div class="auth-container" style="max-width:560px;">
    <div class="auth-card">
        <h2>Add New Product</h2>
        <p class="subtitle">Fill in the details for your product</p>

        <form method="POST" action="/seller/products">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Wireless Earbuds" value="{{ old('name') }}" required>
            </div>

            <div class="grid grid-2" style="gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control" required>
                        <option value="">Select brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-2" style="gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="price">Price (৳)</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ old('price') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" min="0" placeholder="0" value="{{ old('stock') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Describe your product..." rows="4">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Product</button>
        </form>
    </div>
</div>
@endsection
