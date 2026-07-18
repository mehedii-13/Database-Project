@extends('layouts.app')

@section('title', 'Login — বেচাকেনা')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Sign in to your বেচাকেনা account</p>

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="/register">Create one</a>
        </div>

        <div class="auth-footer" style="margin-top: 0.5rem;">
            <span class="text-muted" style="font-size: 0.8rem;">Admin: admin@bechakena.com / password123</span>
        </div>
    </div>
</div>
@endsection
