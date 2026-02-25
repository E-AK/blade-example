<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CustomTable;
use App\Models\CustomTableRow;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomTableRowFactory extends Factory
{
    protected $model = CustomTableRow::class;

    public function definition(): array
    {
        return [
            'custom_table_id' => CustomTable::factory(),
            'values' => [],
        ];
    }

    /**
     * Set the table and fill values from its column definitions.
     */
    public function forTable(CustomTable $table): static
    {
        $columns = $table->columns;
        $values = [];
        foreach ($columns as $col) {
            $values[$col->id] = match ($col->type) {
                'integer' => fake()->numberBetween(0, 9999),
                'decimal' => fake()->randomFloat(2, 0, 1000),
                'boolean' => fake()->boolean(),
                'date' => fake()->date(),
                default => fake()->word(),
            };
        }

        return $this->state(fn () => [
            'custom_table_id' => $table->id,
            'values' => $values,
        ]);
    }
}
