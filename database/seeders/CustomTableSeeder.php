<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CustomTable;
use Illuminate\Database\Seeder;

class CustomTableSeeder extends Seeder
{
    public function run(): void
    {
        CustomTable::factory()->count(10)->create();
    }
}
