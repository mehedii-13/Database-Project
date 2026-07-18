<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::insert("
            INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)
        ", ['Admin', 'admin@bechakena.com', Hash::make('password123'), 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::delete("DELETE FROM users WHERE email = ?", ['admin@bechakena.com']);
    }
};
