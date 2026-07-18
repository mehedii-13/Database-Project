<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class BrandRepository
{
    /**
     * Get all brands.
     */
    public function all(): array
    {
        return DB::select("SELECT * FROM brands ORDER BY brand_name ASC");
    }

    /**
     * Find a brand by ID.
     */
    public function findById(int $brandId): ?object
    {
        $results = DB::select("SELECT * FROM brands WHERE brand_id = ?", [$brandId]);
        return $results[0] ?? null;
    }

    /**
     * Create a new brand.
     */
    public function create(string $brandName): int
    {
        DB::insert("INSERT INTO brands (brand_name) VALUES (?)", [$brandName]);
        $result = DB::select("SELECT LAST_INSERT_ID() AS brand_id");
        return (int) $result[0]->brand_id;
    }

    /**
     * Update a brand.
     */
    public function update(int $brandId, string $brandName): int
    {
        return DB::update("UPDATE brands SET brand_name = ? WHERE brand_id = ?", [$brandName, $brandId]);
    }

    /**
     * Delete a brand.
     */
    public function delete(int $brandId): int
    {
        return DB::delete("DELETE FROM brands WHERE brand_id = ?", [$brandId]);
    }
}
