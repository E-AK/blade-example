<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SbisConnection;
use Illuminate\Database\Eloquent\Factories\Factory;

class SbisConnectionFactory extends Factory
{
    protected $model = SbisConnection::class;

    public function definition(): array
    {
        $connectionTypes = ['Основное', 'Дополнительное'];

        return [
            'protected_key' => 'sk_live_'.fake()->regexify('[a-z0-9]{16}'),
            'service_key' => 'svc_'.fake()->regexify('[a-z0-9]{12}'),
            'connection_type' => fake()->randomElement($connectionTypes),
            'organization' => fake()->company(),
            'comment' => fake()->optional(0.7)->sentence(),
        ];
    }
}
