<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SellerRepository
{
    /**
     * Create a seller shop profile.
     */
    public function createShop(int $userId, string $shopName, ?string $shopDescription = null): int
    {
        DB::insert(
            "INSERT INTO sellers (user_id, shop_name, shop_description) VALUES (?, ?, ?)",
            [$userId, $shopName, $shopDescription]
        );

        $result = DB::select("SELECT LAST_INSERT_ID() AS seller_id");

        return (int) $result[0]->seller_id;
    }

    /**
     * Find seller by user_id.
     */
    public function findByUserId(int $userId): ?object
    {
        $results = DB::select(
            "SELECT s.*, u.name, u.email FROM sellers s JOIN users u ON s.user_id = u.user_id WHERE s.user_id = ?",
            [$userId]
        );

        return $results[0] ?? null;
    }

    /**
     * Find seller by seller_id.
     */
    public function findById(int $sellerId): ?object
    {
        $results = DB::select(
            "SELECT s.*, u.name, u.email FROM sellers s JOIN users u ON s.user_id = u.user_id WHERE s.seller_id = ?",
            [$sellerId]
        );

        return $results[0] ?? null;
    }

    /**
     * Update shop info.
     */
    public function updateShop(int $sellerId, string $shopName, ?string $shopDescription = null): int
    {
        return DB::update(
            "UPDATE sellers SET shop_name = ?, shop_description = ? WHERE seller_id = ?",
            [$shopName, $shopDescription, $sellerId]
        );
    }

    /**
     * Get order history for a seller (orders containing their products).
     */
    public function getSellerOrderHistory(int $sellerId): array
    {
        return DB::select("
            SELECT DISTINCT o.order_id, o.customer_id, o.order_date, o.status, u.name AS customer_name
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN products p ON oi.product_id = p.product_id
            JOIN users u ON o.customer_id = u.user_id
            WHERE p.seller_id = ?
            ORDER BY o.order_date DESC
        ", [$sellerId]);
    }
}
