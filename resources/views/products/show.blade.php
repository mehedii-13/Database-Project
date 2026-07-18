@extends('layouts.app')

@section('title', $product->name . ' — বেচাকেনা')

@section('content')
<div style="margin-bottom:1rem;">
    <a href="/products" class="text-muted" style="font-size:0.9rem;">← Back to products</a>
</div>

<div class="grid grid-2" style="gap:2rem;">
    <!-- Product Info -->
    <div class="card">
        <div style="display:flex;gap:0.5rem;margin-bottom:1rem;">
            <span class="badge badge-primary">{{ $product->category_name }}</span>
            <span class="badge badge-info">{{ $product->brand_name }}</span>
            @if($product->status === 'out_of_stock')
                <span class="badge badge-danger">Out of Stock</span>
            @else
                <span class="badge badge-success">Available</span>
            @endif
        </div>

        <h1 style="font-size:1.75rem;margin-bottom:0.5rem;">{{ $product->name }}</h1>
        <p class="text-muted" style="margin-bottom:1rem;">Sold by <strong>{{ $product->shop_name }}</strong></p>

        <div class="price" style="font-size:2rem;margin-bottom:1rem;">৳{{ number_format($product->price, 2) }}</div>

        @if($avgRating)
        <div style="margin-bottom:1rem;">
            <span class="stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($avgRating))★@else<span class="stars-muted">★</span>@endif
                @endfor
            </span>
            <span class="text-muted" style="font-size:0.85rem;">{{ $avgRating }} / 5 ({{ count($reviews) }} review{{ count($reviews) !== 1 ? 's' : '' }})</span>
        </div>
        @endif

        <p style="margin-bottom:1rem;">{{ $product->stock }} items in stock</p>

        @if($product->description)
        <div style="margin-bottom:1.5rem;">
            <h3 style="font-size:1rem;margin-bottom:0.5rem;color:var(--text-secondary);">Description</h3>
            <p style="color:var(--text-secondary);line-height:1.8;">{{ $product->description }}</p>
        </div>
        @endif

        @if(session('role') === 'customer' && $product->status === 'available')
        <form method="POST" action="/cart/add">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
            <div style="display:flex;gap:1rem;align-items:center;">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:80px;">
                <button type="submit" class="btn btn-primary">🛒 Add to Cart</button>
            </div>
        </form>
        @endif
    </div>

    <!-- Reviews Section -->
    <div>
        <div class="card" style="margin-bottom:1.5rem;">
            <div class="card-header">Reviews ({{ count($reviews) }})</div>

            @if(count($reviews) > 0)
                @foreach($reviews as $review)
                <div style="padding:1rem 0;border-bottom:1px solid var(--border-color);">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                        <strong style="font-size:0.9rem;">{{ $review->customer_name }}</strong>
                        <span class="text-muted" style="font-size:0.8rem;">{{ $review->created_at }}</span>
                    </div>
                    <div class="stars" style="margin-bottom:0.3rem;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)★@else<span class="stars-muted">★</span>@endif
                        @endfor
                    </div>
                    @if($review->comment)
                        <p style="color:var(--text-secondary);font-size:0.9rem;">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach
            @else
                <p class="text-muted">No reviews yet.</p>
            @endif
        </div>

        <!-- Review Form -->
        @if(session('role') === 'customer')
            @if($canReview && !$hasReviewed)
            <div class="card">
                <div class="card-header">Write a Review</div>
                <form method="POST" action="/products/{{ $product->product_id }}/reviews">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-control" required>
                            <option value="">Select rating</option>
                            <option value="5">★★★★★ Excellent</option>
                            <option value="4">★★★★ Good</option>
                            <option value="3">★★★ Average</option>
                            <option value="2">★★ Poor</option>
                            <option value="1">★ Terrible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Comment (optional)</label>
                        <textarea name="comment" class="form-control" placeholder="Share your experience..." rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
            @elseif($hasReviewed)
                <div class="alert alert-info">You have already reviewed this product.</div>
            @else
                <div class="alert alert-warning">You can only review products you have purchased.</div>
            @endif
        @endif
    </div>
</div>
@endsection
