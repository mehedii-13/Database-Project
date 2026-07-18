<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE TABLE products (
                product_id INT AUTO_INCREMENT PRIMARY KEY,
                seller_id INT NOT NULL,
                category_id INT NOT NULL,
                brand_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                stock INT NOT NULL DEFAULT 0,
                description TEXT,
                status ENUM('available','out_of_stock') NOT NULL DEFAULT 'available',
                FOREIGN KEY (seller_id) REFERENCES sellers(seller_id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES categories(category_id),
                FOREIGN KEY (brand_id) REFERENCES brands(brand_id)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS products");
    }
};
