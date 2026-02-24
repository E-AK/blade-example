<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DataStorage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataStorageFactory extends Factory
{
    protected $model = DataStorage::class;

    public function definition(): array
    {
        return [
            'server_address' => fake()->ipv4().':'.fake()->numberBetween(3306, 5432),
            'database_name' => fake()->slug(2),
            'user' => fake()->userName(),
            'password' => fake()->password(12, 24),
            'ip_access' => fake()->optional(0.6)->ipv4(),
            'comment' => fake()->optional(0.7)->sentence(),
        ];
    }
}
