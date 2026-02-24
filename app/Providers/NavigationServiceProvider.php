<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $navigation = $this->app->make(Navigation::class);

        $navigation
            ->add('Подключения', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_connections', 'shortText' => 'Подкл-я']);
                $section->add('Аккаунты Сбис', url('/connections/sbis'));
                $section->add('Хранилище данных', url('/connections/data-storage'));
                $section->add('Wazzup 24', '#');
            })
            ->add('Сбор информации', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_get_info', 'shortText' => 'Сбор ин-']);
                $section->add('Пользовательские таблицы', '#');
                $section->add('Сотрудники', '#');
                $section->add('Лиды', '#');
                $section->add('События', '#');
                $section->add('Исходящие', '#');
                $section->add('Реализация', '#');
                $section->add('Обращения', '#');
                $section->add('Наряды', '#');
                $section->add('Звонки', '#');
                $section->add('Номенклатура', '#');
                $section->add('Виды работ', '#');
                $section->add('Чеки', '#');
                $section->add('Настройка импорта данных', '#');
                $section->add('Витрина данных', '#');
            })
            ->add('Сервисы', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_services', 'shortText' => 'Сервисы']);
                $section->add('Сервис сокращения ссылок', '#');
                $section->add('Списание в пересорт', '#');
                $section->add('Отчет "Потребности"', '#');
                $section->add('Инвентаризация', '#');
                $section->add('Менеджер паролей', '#');
                $section->add('WordPress', '#');
                $section->add('Интеграция с liko', '#');
                $section->add('Отправка опросного лица', '#');
                $section->add('Интеграция с поставщиками шин', '#');
                $section->add('Номенклатура', '#');
                $section->add('Виды работ', '#');
                $section->add('Чеки', '#');
                $section->add('Настройка импорта данных', '#');
                $section->add('Витрина данных', '#');
            })
            ->add('Цепочки событий', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_chain', 'shortText' => 'Цепочки']);
            })
            ->add('Отчеты', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_report', 'shortText' => 'Отчеты']);
            })
            ->add('Планирование', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_planning', 'shortText' => 'План-е']);
            })
            ->add('Настройки', '#', function (Section $section): void {
                $section->attributes(['icon' => 'menu_settings', 'shortText' => 'Наст-ки']);
                $section->add('Настройки аккаунта', '#');
                $section->add('Настройка вебхуков', '#');
                $section->add('Управление аккаунтами', url('/settings/account'));
            })
            ->add('Аккаунты', url('/account'), function (Section $section): void {
                $section->attributes(['icon' => 'menu_accounts', 'shortText' => 'Аккаунты']);
            })
            ->add('Пользователи', url('/users'), function (Section $section): void {
                $section->attributes(['icon' => 'menu_user', 'shortText' => 'Польз-ли']);
            });
    }
}
