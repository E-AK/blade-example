<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CustomTable;
use App\Models\CustomTableColumn;
use Illuminate\Database\Seeder;

class CustomTableColumnSeeder extends Seeder
{
    public function run(): void
    {
        foreach (CustomTable::all() as $table) {
            foreach (range(0, 2) as $order) {
                CustomTableColumn::factory()->create([
                    'custom_table_id' => $table->id,
                    'sort_order' => $order,
                ]);
            }
        }
    }
}
