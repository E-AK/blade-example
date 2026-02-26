<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class ShortLinkSeeder extends Seeder
{
    public function run(): void
    {
        ShortLink::factory()->count(10)->create();
    }
}
