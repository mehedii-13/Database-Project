<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CartRepository
{
    /**
     * Get or create a cart for a customer.
     */
    public function getOrCreateCartForCustomer(int $customerId): int
    {
        $cart = DB::select("SELECT cart_id FROM carts WHERE customer_id = ?", [$customerId]);

        if (!empty($cart)) {
            return (int) $cart[0]->cart_id;
        }

        DB::insert("INSERT INTO carts (customer_id) VALUES (?)", [$customerId]);
        $result = DB::select("SELECT LAST_INSERT_ID() AS cart_id");

        return (int) $result[0]->cart_id;
    }

    /**
     * Add item to cart (or increment quantity if already exists).
     */
    public function addItem(int $cartId, int $productId, int $quantity = 1): void
    {
        // Check if already in cart
        $existing = DB::select(
            "SELECT cart_item_id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?",
            [$cartId, $productId]
        );

        if (!empty($existing)) {
            DB::update(
                "UPDATE cart_items SET quantity = quantity + ? WHERE cart_item_id = ?",
                [$quantity, $existing[0]->cart_item_id]
            );
        } else {
            DB::insert(
                "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)",
                [$cartId, $productId, $quantity]
            );
        }
    }

    /**
     * Update item quantity.
     */
    public function updateQuantity(int $cartItemId, int $quantity): int
    {
        if ($quantity <= 0) {
            return DB::delete("DELETE FROM cart_items WHERE cart_item_id = ?", [$cartItemId]);
        }

        return DB::update(
            "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?",
            [$quantity, $cartItemId]
        );
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(int $cartItemId): int
    {
        return DB::delete("DELETE FROM cart_items WHERE cart_item_id = ?", [$cartItemId]);
    }

    /**
     * Get cart summary with product details (JOIN).
     */
    public function getCartSummary(int $customerId): array
    {
        return DB::select("
            SELECT ci.cart_item_id, ci.quantity, p.product_id, p.name, p.price, p.stock, p.status,
                   (ci.quantity * p.price) AS subtotal, b.brand_name, s.shop_name
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.cart_id
            JOIN products p ON ci.product_id = p.product_id
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN sellers s ON p.seller_id = s.seller_id
            WHERE c.customer_id = ?
            ORDER BY ci.cart_item_id ASC
        ", [$customerId]);
    }

    /**
     * Get cart items (raw) for checkout.
     */
    public function getCartItems(int $cartId): array
    {
        return DB::select("
            SELECT ci.cart_item_id, ci.product_id, ci.quantity, p.price, p.stock, p.name
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.product_id
            WHERE ci.cart_id = ?
        ", [$cartId]);
    }

    /**
     * Clear all items from a cart.
     */
    public function clearCart(int $cartId): int
    {
        return DB::delete("DELETE FROM cart_items WHERE cart_id = ?", [$cartId]);
    }
}
