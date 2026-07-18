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
            CREATE TABLE carts (
                cart_id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                FOREIGN KEY (customer_id) REFERENCES users(user_id) ON DELETE CASCADE,
                UNIQUE KEY uniq_cart_customer (customer_id)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS carts");
    }
};
