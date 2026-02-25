<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CustomTable;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomTableFactory extends Factory
{
    protected $model = CustomTable::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(4, true),
            'row_count' => fake()->numberBetween(0, 10000),
            'data_volume' => fake()->randomElement(['0.5 MB', '1.2 MB', '15 MB', '128 KB']),
        ];
    }
}
