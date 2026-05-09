<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat atau update user test
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['full_name' => 'Test User']
        );

        // Buat 9 user dummy tambahan
        // User::factory(9)->create();
    }
}
