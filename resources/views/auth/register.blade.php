@extends('layouts.app')

@section('title', 'Register — বেচাকেনা')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Create Account</h2>
        <p class="subtitle">Join বেচাকেনা and start shopping or selling</p>

        <form method="POST" action="/register">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Minimum 6 characters" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-enter your password" required>
            </div>

            <div class="form-group">
                <label class="form-label">I want to</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="role" id="role_customer" value="customer" {{ old('role', 'customer') === 'customer' ? 'checked' : '' }}>
                        <label for="role_customer">🛒 Buy Products</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="role" id="role_seller" value="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                        <label for="role_seller">🏪 Sell Products</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="/login">Sign in</a>
        </div>
    </div>
</div>
@endsection
