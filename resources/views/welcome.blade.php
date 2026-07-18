@extends('layouts.app')

@section('title', 'বেচাকেনা — E-Commerce Marketplace')

@section('styles')
<style>
    .hero {
        text-align: center;
        padding: 5rem 1rem;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -1px;
    }

    .hero p {
        font-size: 1.15rem;
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto 2rem;
        line-height: 1.8;
    }

    .hero-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 4rem;
    }

    .feature-card {
        text-align: center;
        padding: 2rem 1.5rem;
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .feature-card h3 {
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .feature-card p {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .hero h1 { font-size: 2rem; }
        .features { grid-template-columns: 1fr; }
        .hero-actions { flex-direction: column; align-items: center; }
    }
</style>
@endsection

@section('content')
<div class="hero">
    <h1>বেচাকেনা</h1>
    <p>Your trusted e-commerce marketplace. Discover amazing products from verified sellers across Bangladesh, or start your own shop today.</p>

    <div class="hero-actions">
        <a href="/products" class="btn btn-primary">Browse Products</a>
        @if(!session('user_id'))
            <a href="/register" class="btn btn-secondary">Create Account</a>
        @endif
    </div>
</div>

<div class="features">
    <div class="card feature-card">
        <div class="feature-icon">🛍️</div>
        <h3>Shop with Confidence</h3>
        <p>Browse thousands of products from verified sellers. Read reviews and compare prices.</p>
    </div>
    <div class="card feature-card">
        <div class="feature-icon">🏪</div>
        <h3>Start Selling</h3>
        <p>Open your own shop in minutes. Manage products, track orders, and grow your business.</p>
    </div>
    <div class="card feature-card">
        <div class="feature-icon">⭐</div>
        <h3>Honest Reviews</h3>
        <p>Only verified buyers can leave reviews. Trust the ratings you see on every product.</p>
    </div>
</div>
@endsection
