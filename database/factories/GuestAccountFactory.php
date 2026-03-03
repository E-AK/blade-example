<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\GuestAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GuestAccount>
 */
class GuestAccountFactory extends Factory
{
    protected $model = GuestAccount::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => null,
            'comment' => fake()->optional()->sentence(),
            'connections' => fake()->boolean(30),
            'data_collection' => fake()->boolean(30),
            'custom_tables' => fake()->boolean(30),
            'services' => fake()->boolean(30),
            'event_chains' => fake()->boolean(30),
            'reports' => fake()->boolean(30),
        ];
    }
}
