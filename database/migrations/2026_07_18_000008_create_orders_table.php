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
            CREATE TABLE orders (
                order_id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                status ENUM('pending','paid','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
                FOREIGN KEY (customer_id) REFERENCES users(user_id)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS orders");
    }
};
