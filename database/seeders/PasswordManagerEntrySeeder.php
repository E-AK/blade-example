<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PasswordManagerEntry;
use Illuminate\Database\Seeder;

class PasswordManagerEntrySeeder extends Seeder
{
    public function run(): void
    {
        $folders = [
            'Пароли от акаунтов',
            'Рабочие',
            'Личные',
            'Сервисы',
            'Почта и мессенджеры',
            'CRM и сервисы',
            'Соцсети',
            'Банки',
            'Архив',
            'Общие доступы',
        ];

        foreach (range(1, 25) as $i) {
            PasswordManagerEntry::factory()->create([
                'name' => fake()->randomElement([
                    'Google Workspace', 'Яндекс', 'Telegram', 'Slack', '1C', 'СберБизнес',
                    'ВКонтакте', 'Сбербанк', 'Тинькофф', 'Notion', 'Figma', 'GitHub',
                    'Jira', 'Bitrix24', 'Мой офис', 'Рамблер', 'Почта России',
                ]).($i > 12 ? ' ('.fake()->word().')' : ''),
                'folder' => fake()->randomElement($folders),
                'login' => fake()->userName().(fake()->boolean(30) ? '@'.fake()->domainWord().'.ru' : ''),
                'password' => fake()->password(12, 24),
                'comment' => fake()->optional(0.4)->sentence(),
            ]);
        }
    }
}
