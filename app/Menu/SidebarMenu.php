<?php

declare(strict_types=1);

namespace App\Menu;

use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Menu;

class SidebarMenu
{
    public static function render(): string
    {
        return Menu::new()
            ->setActiveFromRequest()
            ->submenu('Настройки', Menu::new()
                ->addClass('submenu')
                ->link(route('settings.account'), 'Настройки аккаунта')
            )
            ->render();
    }
}
