<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * Create a new product.
     */
    public function create(int $sellerId, int $categoryId, int $brandId, string $name, float $price, int $stock, ?string $description = null): int
    {
        DB::insert("
            INSERT INTO products (seller_id, category_id, brand_id, name, price, stock, description, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ", [$sellerId, $categoryId, $brandId, $name, $price, $stock, $description, $stock > 0 ? 'available' : 'out_of_stock']);

        $result = DB::select("SELECT LAST_INSERT_ID() AS product_id");
        return (int) $result[0]->product_id;
    }

    /**
     * Update a product.
     */
    public function update(int $productId, int $categoryId, int $brandId, string $name, float $price, int $stock, ?string $description = null): int
    {
        return DB::update("
            UPDATE products SET category_id = ?, brand_id = ?, name = ?, price = ?, stock = ?, description = ?,
            status = CASE WHEN ? > 0 THEN 'available' ELSE 'out_of_stock' END
            WHERE product_id = ?
        ", [$categoryId, $brandId, $name, $price, $stock, $description, $stock, $productId]);
    }

    /**
     * Delete a product.
     */
    public function delete(int $productId): int
    {
        return DB::delete("DELETE FROM products WHERE product_id = ?", [$productId]);
    }

    /**
     * Find a product by ID (with brand/category/seller info).
     */
    public function findById(int $productId): ?object
    {
        $results = DB::select("
            SELECT p.*, b.brand_name, c.category_name, s.shop_name, s.seller_id, u.name AS seller_user_name
            FROM products p
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN categories c ON p.category_id = c.category_id
            JOIN sellers s ON p.seller_id = s.seller_id
            JOIN users u ON s.user_id = u.user_id
            WHERE p.product_id = ?
        ", [$productId]);

        return $results[0] ?? null;
    }

    /**
     * Browse products with search, filter, sort, and pagination.
     */
    public function browse(?string $search = null, ?int $categoryId = null, ?int $brandId = null, string $sortBy = 'name', string $sortDir = 'ASC', int $limit = 12, int $offset = 0): array
    {
        $where = [];
        $params = [];

        if ($search) {
            $where[] = "p.name LIKE ?";
            $params[] = "%{$search}%";
        }

        if ($categoryId) {
            $where[] = "p.category_id = ?";
            $params[] = $categoryId;
        }

        if ($brandId) {
            $where[] = "p.brand_id = ?";
            $params[] = $brandId;
        }

        $whereClause = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        // Sanitize sort
        $allowedSorts = ['name' => 'p.name', 'price' => 'p.price', 'newest' => 'p.product_id'];
        $sortColumn = $allowedSorts[$sortBy] ?? 'p.name';
        $sortDirection = strtoupper($sortDir) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "
            SELECT p.*, b.brand_name, c.category_name, s.shop_name
            FROM products p
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN categories c ON p.category_id = c.category_id
            JOIN sellers s ON p.seller_id = s.seller_id
            {$whereClause}
            ORDER BY {$sortColumn} {$sortDirection}
            LIMIT ? OFFSET ?
        ";

        $params[] = $limit;
        $params[] = $offset;

        return DB::select($sql, $params);
    }

    /**
     * Count products for pagination.
     */
    public function countBrowse(?string $search = null, ?int $categoryId = null, ?int $brandId = null): int
    {
        $where = [];
        $params = [];

        if ($search) {
            $where[] = "p.name LIKE ?";
            $params[] = "%{$search}%";
        }

        if ($categoryId) {
            $where[] = "p.category_id = ?";
            $params[] = $categoryId;
        }

        if ($brandId) {
            $where[] = "p.brand_id = ?";
            $params[] = $brandId;
        }

        $whereClause = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "SELECT COUNT(*) AS total FROM products p {$whereClause}";

        $result = DB::select($sql, $params);
        return (int) $result[0]->total;
    }

    /**
     * List products by seller.
     */
    public function listBySeller(int $sellerId): array
    {
        return DB::select("
            SELECT p.*, b.brand_name, c.category_name
            FROM products p
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.seller_id = ?
            ORDER BY p.product_id DESC
        ", [$sellerId]);
    }

    /**
     * Update stock and auto-set status.
     */
    public function updateStock(int $productId, int $newStock): int
    {
        return DB::update("
            UPDATE products SET stock = ?, status = CASE WHEN ? > 0 THEN 'available' ELSE 'out_of_stock' END
            WHERE product_id = ?
        ", [$newStock, $newStock, $productId]);
    }

    /**
     * Set product status.
     */
    public function setStatus(int $productId, string $status): int
    {
        return DB::update("UPDATE products SET status = ? WHERE product_id = ?", [$status, $productId]);
    }
}
