<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DataShowcase;
use Illuminate\Database\Seeder;

class DataShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $showcases = [
            [
                'name' => 'Контакты Сбис',
                'section' => 'Сотрудники',
                'table_name' => 'usertable_contacts',
                'period' => '01.01.2025 — 25.02.2025',
                'status' => 'success',
                'row_count' => 12500,
                'loaded_rows' => 12500,
                'progress' => 100,
            ],
            [
                'name' => 'Заказы',
                'section' => 'Реализация',
                'table_name' => 'usertable_orders',
                'period' => 'Текущий месяц',
                'status' => 'attention',
                'row_count' => 8400,
                'loaded_rows' => 6200,
                'progress' => 74,
            ],
            [
                'name' => 'Лиды',
                'section' => 'Лиды',
                'table_name' => 'usertable_leads',
                'period' => '01.02.2025 — 20.02.2025',
                'status' => 'info',
                'row_count' => 0,
                'loaded_rows' => 0,
                'progress' => 0,
            ],
            [
                'name' => 'Номенклатура',
                'section' => 'Номенклатура',
                'table_name' => 'usertable_products',
                'period' => '01.12.2024 — 25.02.2025',
                'status' => 'pause',
                'row_count' => 56000,
                'loaded_rows' => 28000,
                'progress' => 50,
            ],
            [
                'name' => 'События',
                'section' => 'События',
                'table_name' => 'usertable_events',
                'period' => '—',
                'status' => 'error',
                'row_count' => 0,
                'loaded_rows' => 0,
                'progress' => 0,
            ],
        ];

        foreach ($showcases as $data) {
            DataShowcase::query()->firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
