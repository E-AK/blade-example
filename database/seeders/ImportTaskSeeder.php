<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ImportTask;
use Illuminate\Database\Seeder;

class ImportTaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'command' => 'import:contacts',
                'collect_from_date' => true,
                'period_start_date' => '2025-01-01',
                'period_end_date' => '2025-02-25',
                'records_count' => 1250,
                'webhook_mode' => 'send',
                'status' => 'success',
            ],
            [
                'command' => 'import:orders',
                'collect_from_date' => false,
                'period_start_date' => null,
                'period_end_date' => null,
                'records_count' => 840,
                'webhook_mode' => 'delete',
                'status' => 'attention',
            ],
            [
                'command' => 'import:leads',
                'collect_from_date' => true,
                'period_start_date' => '2025-02-01',
                'period_end_date' => '2025-02-20',
                'records_count' => 312,
                'webhook_mode' => 'send',
                'status' => 'info',
            ],
            [
                'command' => 'import:inventory',
                'collect_from_date' => true,
                'period_start_date' => '2024-12-01',
                'period_end_date' => '2025-02-25',
                'records_count' => 5600,
                'webhook_mode' => 'send',
                'status' => 'pause',
            ],
            [
                'command' => 'import:events',
                'collect_from_date' => false,
                'period_start_date' => null,
                'period_end_date' => null,
                'records_count' => 0,
                'webhook_mode' => 'delete',
                'status' => 'error',
            ],
        ];

        foreach ($tasks as $data) {
            ImportTask::query()->firstOrCreate(
                ['command' => $data['command']],
                $data
            );
        }
    }
}
