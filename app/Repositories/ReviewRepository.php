<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ReviewRepository
{
    /**
     * Create a review.
     */
    public function create(int $customerId, int $productId, int $rating, ?string $comment = null): int
    {
        DB::insert("
            INSERT INTO reviews (customer_id, product_id, rating, comment) VALUES (?, ?, ?, ?)
        ", [$customerId, $productId, $rating, $comment]);

        $result = DB::select("SELECT LAST_INSERT_ID() AS review_id");
        return (int) $result[0]->review_id;
    }

    /**
     * Get reviews for a product.
     */
    public function getByProduct(int $productId): array
    {
        return DB::select("
            SELECT r.*, u.name AS customer_name
            FROM reviews r
            JOIN users u ON r.customer_id = u.user_id
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC
        ", [$productId]);
    }

    /**
     * Get average rating for a product.
     */
    public function getAverageRating(int $productId): ?float
    {
        $result = DB::select("
            SELECT AVG(rating) AS avg_rating, COUNT(*) AS review_count
            FROM reviews WHERE product_id = ?
        ", [$productId]);

        if (empty($result) || $result[0]->review_count == 0) {
            return null;
        }

        return round((float) $result[0]->avg_rating, 1);
    }

    /**
     * Check if a customer has purchased a product (via delivered/paid orders).
     */
    public function hasPurchased(int $customerId, int $productId): bool
    {
        $result = DB::select("
            SELECT COUNT(*) AS cnt FROM order_items oi
            JOIN orders o ON oi.order_id = o.order_id
            WHERE o.customer_id = ? AND oi.product_id = ? AND o.status IN ('paid', 'shipped', 'delivered')
        ", [$customerId, $productId]);

        return (int) $result[0]->cnt > 0;
    }

    /**
     * Check if customer already reviewed this product.
     */
    public function hasReviewed(int $customerId, int $productId): bool
    {
        $result = DB::select(
            "SELECT COUNT(*) AS cnt FROM reviews WHERE customer_id = ? AND product_id = ?",
            [$customerId, $productId]
        );

        return (int) $result[0]->cnt > 0;
    }
}
