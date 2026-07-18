@extends('layouts.app')

@section('title', 'Add Category — Admin')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Add Category</h2>
        <form method="POST" action="/admin/categories">
            @csrf
            <div class="form-group">
                <label class="form-label" for="category_name">Category Name</label>
                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="e.g. Electronics" value="{{ old('category_name') }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Category</button>
        </form>
    </div>
</div>
@endsection
