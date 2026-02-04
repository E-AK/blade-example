<?php

declare(strict_types=1);

namespace App\Menu;

use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class SidebarMenu
{
    public static function render(): string
    {
        return Menu::new()
            ->addClass('sidebar-menu list-unstyled mb-0')
            ->setActiveFromRequest()
            ->submenu(
                MenuSection::make('Настройки', [
                    'href' => '',
                    'hasChildren' => true,
                    'icon' => '<i class="bi bi-toggles menu-section-icon"></i>'
                ]),
                Menu::new()
                    ->addClass('sidebar-dropdown list-unstyled')
                    ->setAttribute('data-dropdown-menu', 'services')
                    ->add(
                        Link::to(route('settings.account'), 'Управление аккаунтами')
                            ->addClass('l2')
                    )
            )
            ->render();
    }
}
