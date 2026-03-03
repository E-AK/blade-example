<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GuestAccount;
use Illuminate\Database\Seeder;

class GuestAccountSeeder extends Seeder
{
    public function run(): void
    {
        GuestAccount::factory()->count(10)->create();
    }
}
