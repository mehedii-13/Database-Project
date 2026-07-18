<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Create a new user.
     *
     * @param string $name
     * @param string $email
     * @param string $password (plain text — will be hashed)
     * @param string $role
     * @return int The inserted user_id
     */
    public function create(string $name, string $email, string $password, string $role = 'customer'): int
    {
        DB::insert(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)",
            [$name, $email, Hash::make($password), $role]
        );

        $result = DB::select("SELECT LAST_INSERT_ID() AS user_id");

        return (int) $result[0]->user_id;
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return object|null
     */
    public function findByEmail(string $email): ?object
    {
        $results = DB::select(
            "SELECT user_id, name, email, password, role, created_at FROM users WHERE email = ?",
            [$email]
        );

        return $results[0] ?? null;
    }

    /**
     * Find a user by ID.
     *
     * @param int $userId
     * @return object|null
     */
    public function findById(int $userId): ?object
    {
        $results = DB::select(
            "SELECT user_id, name, email, password, role, created_at FROM users WHERE user_id = ?",
            [$userId]
        );

        return $results[0] ?? null;
    }

    /**
     * Update user profile (name and email).
     *
     * @param int $userId
     * @param string $name
     * @param string $email
     * @return int Number of affected rows
     */
    public function updateProfile(int $userId, string $name, string $email): int
    {
        return DB::update(
            "UPDATE users SET name = ?, email = ? WHERE user_id = ?",
            [$name, $email, $userId]
        );
    }

    /**
     * Update user password.
     *
     * @param int $userId
     * @param string $newPassword (plain text — will be hashed)
     * @return int Number of affected rows
     */
    public function updatePassword(int $userId, string $newPassword): int
    {
        return DB::update(
            "UPDATE users SET password = ? WHERE user_id = ?",
            [Hash::make($newPassword), $userId]
        );
    }
}
