<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DataStorage;
use Illuminate\Database\Seeder;

class DataStorageSeeder extends Seeder
{
    public function run(): void
    {
        DataStorage::factory()->count(10)->create();
    }
}
