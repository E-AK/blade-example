<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CustomTable;
use App\Models\CustomTableColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomTableColumnFactory extends Factory
{
    protected $model = CustomTableColumn::class;

    public function definition(): array
    {
        return [
            'custom_table_id' => CustomTable::factory(),
            'name' => fake()->unique()->word(),
            'type' => fake()->randomElement(['VARCHAR(255)', 'INTEGER', 'DECIMAL(10,2)', 'BOOLEAN', 'DATE']),
            'sort_order' => fake()->numberBetween(0, 100),
            'data_type' => fake()->randomElement(['Строка', 'Число целое', 'Число с запятой', 'Да/Нет', 'Дата']),
            'example_data' => fake()->optional(0.7)->numerify('Пример ###'),
            'is_required' => fake()->boolean(30),
            'comment' => fake()->optional(0.5)->sentence(),
        ];
    }
}
