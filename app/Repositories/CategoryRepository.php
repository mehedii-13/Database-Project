<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    /**
     * Get all categories.
     */
    public function all(): array
    {
        return DB::select("SELECT * FROM categories ORDER BY category_name ASC");
    }

    /**
     * Find a category by ID.
     */
    public function findById(int $categoryId): ?object
    {
        $results = DB::select("SELECT * FROM categories WHERE category_id = ?", [$categoryId]);
        return $results[0] ?? null;
    }

    /**
     * Create a new category.
     */
    public function create(string $categoryName): int
    {
        DB::insert("INSERT INTO categories (category_name) VALUES (?)", [$categoryName]);
        $result = DB::select("SELECT LAST_INSERT_ID() AS category_id");
        return (int) $result[0]->category_id;
    }

    /**
     * Update a category.
     */
    public function update(int $categoryId, string $categoryName): int
    {
        return DB::update("UPDATE categories SET category_name = ? WHERE category_id = ?", [$categoryName, $categoryId]);
    }

    /**
     * Delete a category.
     */
    public function delete(int $categoryId): int
    {
        return DB::delete("DELETE FROM categories WHERE category_id = ?", [$categoryId]);
    }
}
