@extends('layouts.app')

@section('title', 'Categories — Admin')

@section('content')
<div class="page-header">
    <h1>Categories</h1>
    <a href="/admin/categories/create" class="btn btn-primary">+ Add Category</a>
</div>

@if(count($categories) > 0)
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->category_id }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                    <div class="actions">
                        <a href="/admin/categories/{{ $category->category_id }}/edit" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="/admin/categories/{{ $category->category_id }}" method="POST" class="inline-form" onsubmit="return confirm('Delete this category?')">
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
    <h3>No categories yet</h3>
    <p>Add your first category to get started.</p>
</div>
@endif
@endsection
