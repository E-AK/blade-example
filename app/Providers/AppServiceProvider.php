<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view): void {
            $view->with('accounts', $this->defaultAccounts());
        });
    }

    /**
     * Default accounts list (same source as sidebar profile card).
     *
     * @return array<int, array{name: string, active: bool, href: string, users?: array<int, array{name: string, type: string}>}>
     */
    private function defaultAccounts(): array
    {
        return [
            ['name' => 'ООО Сбис-Вятка', 'active' => true, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner'], ['name' => 'Петрова Анна Сергеевна', 'type' => 'member']]],
            ['name' => 'ООО Нутриотика', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
            ['name' => 'ИП Васильев Петр Ильич', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
            ['name' => 'ООО Рога и копыта', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
            ['name' => 'ИП Сидоров А. А.', 'active' => false, 'href' => '#', 'users' => [['name' => 'Петрова Анна Сергеевна', 'type' => 'member']]],
        ];
    }
}
