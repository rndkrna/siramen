<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name'      => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'avatar_url'     => null,
            'provider'       => null,
            'is_premium'     => false,
            'quota_used'     => 0,
            'quota_reset_at' => null,
            'last_login_at'  => null,
        ];
    }
}
