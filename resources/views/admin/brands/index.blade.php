@extends('layouts.app')

@section('title', 'Brands — Admin')

@section('content')
<div class="page-header">
    <h1>Brands</h1>
    <a href="/admin/brands/create" class="btn btn-primary">+ Add Brand</a>
</div>

@if(count($brands) > 0)
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>{{ $brand->brand_id }}</td>
                <td>{{ $brand->brand_name }}</td>
                <td>
                    <div class="actions">
                        <a href="/admin/brands/{{ $brand->brand_id }}/edit" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="/admin/brands/{{ $brand->brand_id }}" method="POST" class="inline-form" onsubmit="return confirm('Delete this brand?')">
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
    <h3>No brands yet</h3>
    <p>Add your first brand to get started.</p>
</div>
@endif
@endsection
