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
            CREATE TABLE sellers (
                seller_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                shop_name VARCHAR(255) NOT NULL,
                shop_description TEXT,
                FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
                UNIQUE KEY uniq_seller_user (user_id)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS sellers");
    }
};
