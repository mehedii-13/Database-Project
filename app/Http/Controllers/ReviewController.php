<?php

namespace App\Http\Controllers;

use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected ReviewRepository $reviewRepo;

    public function __construct(ReviewRepository $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }

    /**
     * List reviews for a product (usually loaded with the product page).
     */
    public function index(int $id)
    {
        $reviews = $this->reviewRepo->getByProduct($id);
        return response()->json($reviews);
    }

    /**
     * Submit a review.
     */
    public function store(Request $request, int $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $customerId = session('user_id');

        // Check if customer purchased this product
        if (!$this->reviewRepo->hasPurchased($customerId, $id)) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        // Check if already reviewed
        if ($this->reviewRepo->hasReviewed($customerId, $id)) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $this->reviewRepo->create(
            $customerId,
            $id,
            (int) $request->input('rating'),
            $request->input('comment')
        );

        return back()->with('success', 'Review submitted!');
    }
}
