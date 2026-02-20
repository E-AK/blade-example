<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SbisConnection;
use Illuminate\Database\Seeder;

class SbisConnectionSeeder extends Seeder
{
    public function run(): void
    {
        $connections = [
            [
                'protected_key' => 'sk_live_abc123secret',
                'service_key' => 'svc_xyz789key',
                'connection_type' => 'Основное',
                'organization' => 'ООО Рога и копыта',
                'comment' => 'Тестовое подключение',
            ],
            [
                'protected_key' => 'sk_live_def456hidden',
                'service_key' => 'svc_uvw012token',
                'connection_type' => 'Дополнительное',
                'organization' => 'ИП Иванов',
                'comment' => 'Резервный аккаунт',
            ],
            [
                'protected_key' => 'sk_live_ghi789private',
                'service_key' => 'svc_rst345api',
                'connection_type' => 'Основное',
                'organization' => 'АО Компания',
                'comment' => null,
            ],
        ];

        foreach ($connections as $data) {
            SbisConnection::query()->firstOrCreate(
                [
                    'protected_key' => $data['protected_key'],
                ],
                $data
            );
        }

        SbisConnection::factory()->count(7)->create();
    }
}
