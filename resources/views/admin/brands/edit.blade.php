@extends('layouts.app')

@section('title', 'Edit Brand — Admin')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Edit Brand</h2>
        <form method="POST" action="/admin/brands/{{ $brand->brand_id }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="brand_name">Brand Name</label>
                <input type="text" name="brand_name" id="brand_name" class="form-control" value="{{ old('brand_name', $brand->brand_name) }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Brand</button>
        </form>
    </div>
</div>
@endsection
