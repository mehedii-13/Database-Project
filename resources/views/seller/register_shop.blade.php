@extends('layouts.app')

@section('title', 'Register Shop — বেচাকেনা')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>🏪 Register Your Shop</h2>
        <p class="subtitle">Set up your shop to start selling on বেচাকেনা</p>

        <form method="POST" action="/seller/register-shop">
            @csrf

            <div class="form-group">
                <label class="form-label" for="shop_name">Shop Name</label>
                <input type="text" name="shop_name" id="shop_name" class="form-control" placeholder="e.g. My Awesome Store" value="{{ old('shop_name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="shop_description">Shop Description</label>
                <textarea name="shop_description" id="shop_description" class="form-control" placeholder="Tell customers about your shop..." rows="4">{{ old('shop_description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Shop</button>
        </form>
    </div>
</div>
@endsection
