<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrderRepository
{
    /**
     * Create an order from the customer's cart.
     * Wrapped in a DB transaction for atomicity.
     */
    public function createOrderFromCart(int $customerId, int $cartId): int
    {
        return DB::transaction(function () use ($customerId, $cartId) {
            // 1. Get cart items with current prices
            $cartItems = DB::select("
                SELECT ci.product_id, ci.quantity, p.price, p.stock, p.name
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = ?
            ", [$cartId]);

            if (empty($cartItems)) {
                throw new \Exception('Your cart is empty.');
            }

            // 2. Validate stock availability
            foreach ($cartItems as $item) {
                if ($item->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for \"{$item->name}\". Available: {$item->stock}, Requested: {$item->quantity}");
                }
            }

            // 3. Insert order
            DB::insert("INSERT INTO orders (customer_id) VALUES (?)", [$customerId]);
            $orderResult = DB::select("SELECT LAST_INSERT_ID() AS order_id");
            $orderId = (int) $orderResult[0]->order_id;

            // 4. Insert order items with price at purchase
            foreach ($cartItems as $item) {
                DB::insert("
                    INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
                    VALUES (?, ?, ?, ?)
                ", [$orderId, $item->product_id, $item->quantity, $item->price]);

                // 5. Decrement stock
                $newStock = $item->stock - $item->quantity;
                DB::update("
                    UPDATE products SET stock = ?, status = CASE WHEN ? > 0 THEN 'available' ELSE 'out_of_stock' END
                    WHERE product_id = ?
                ", [$newStock, $newStock, $item->product_id]);
            }

            // 6. Clear cart items
            DB::delete("DELETE FROM cart_items WHERE cart_id = ?", [$cartId]);

            return $orderId;
        });
    }

    /**
     * Update order status.
     */
    public function updateStatus(int $orderId, string $status): int
    {
        return DB::update("UPDATE orders SET status = ? WHERE order_id = ?", [$status, $orderId]);
    }

    /**
     * Get orders by customer.
     */
    public function getOrdersByCustomer(int $customerId): array
    {
        return DB::select("
            SELECT o.*,
                   (SELECT SUM(oi.quantity * oi.price_at_purchase) FROM order_items oi WHERE oi.order_id = o.order_id) AS total,
                   (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.order_id) AS item_count
            FROM orders o
            WHERE o.customer_id = ?
            ORDER BY o.order_date DESC
        ", [$customerId]);
    }

    /**
     * Get order details (items with product info).
     */
    public function getOrderDetails(int $orderId): ?object
    {
        $orders = DB::select("
            SELECT o.*, u.name AS customer_name, u.email AS customer_email
            FROM orders o
            JOIN users u ON o.customer_id = u.user_id
            WHERE o.order_id = ?
        ", [$orderId]);

        if (empty($orders)) {
            return null;
        }

        $order = $orders[0];
        $order->items = DB::select("
            SELECT oi.*, p.name AS product_name, b.brand_name, s.shop_name
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN sellers s ON p.seller_id = s.seller_id
            WHERE oi.order_id = ?
        ", [$orderId]);

        $order->total = array_sum(array_map(function ($item) {
            return $item->quantity * $item->price_at_purchase;
        }, $order->items));

        return $order;
    }

    /**
     * Get all orders (for admin).
     */
    public function getAllOrders(): array
    {
        return DB::select("
            SELECT o.*, u.name AS customer_name,
                   (SELECT SUM(oi.quantity * oi.price_at_purchase) FROM order_items oi WHERE oi.order_id = o.order_id) AS total,
                   (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.order_id) AS item_count
            FROM orders o
            JOIN users u ON o.customer_id = u.user_id
            ORDER BY o.order_date DESC
        ");
    }

    /**
     * Get orders containing products from a specific seller.
     */
    public function getOrdersBySeller(int $sellerId): array
    {
        return DB::select("
            SELECT DISTINCT o.*, u.name AS customer_name,
                   (SELECT SUM(oi2.quantity * oi2.price_at_purchase)
                    FROM order_items oi2
                    JOIN products p2 ON oi2.product_id = p2.product_id
                    WHERE oi2.order_id = o.order_id AND p2.seller_id = ?) AS seller_total
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN products p ON oi.product_id = p.product_id
            JOIN users u ON o.customer_id = u.user_id
            WHERE p.seller_id = ?
            ORDER BY o.order_date DESC
        ", [$sellerId, $sellerId]);
    }
}
