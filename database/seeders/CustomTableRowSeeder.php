<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CustomTable;
use App\Models\CustomTableRow;
use Illuminate\Database\Seeder;

class CustomTableRowSeeder extends Seeder
{
    public function run(): void
    {
        foreach (CustomTable::all() as $table) {
            if ($table->columns->isEmpty()) {
                continue;
            }
            for ($i = 0; $i < 5; $i++) {
                CustomTableRow::factory()->forTable($table)->create();
            }
        }
    }
}
