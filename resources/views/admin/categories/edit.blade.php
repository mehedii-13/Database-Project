@extends('layouts.app')

@section('title', 'Edit Category — Admin')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Edit Category</h2>
        <form method="POST" action="/admin/categories/{{ $category->category_id }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="category_name">Category Name</label>
                <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Category</button>
        </form>
    </div>
</div>
@endsection
