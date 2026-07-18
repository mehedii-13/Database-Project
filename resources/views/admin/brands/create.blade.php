@extends('layouts.app')

@section('title', 'Add Brand — Admin')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Add Brand</h2>
        <form method="POST" action="/admin/brands">
            @csrf
            <div class="form-group">
                <label class="form-label" for="brand_name">Brand Name</label>
                <input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="e.g. Samsung" value="{{ old('brand_name') }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Brand</button>
        </form>
    </div>
</div>
@endsection
