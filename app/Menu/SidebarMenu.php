<?php

declare(strict_types=1);

namespace App\Menu;

use Spatie\Menu\Laravel\Menu;

class SidebarMenu
{
    public static function render(): string
    {
        $sub = Menu::new()
            ->addClass('sidebar-menu list-unstyled mb-0')
            ->add(MenuSection::make('Управление аккаунтами', [
                'href' => route('settings.account'),
                'isSubmenu' => true,
            ]));

        return Menu::new()
            ->addClass('sidebar-menu list-unstyled mb-0')
            ->add(
                SidebarDropdown::make(
                    MenuSection::make('Настройки', [
                        'asButton' => true,
                        'hasChildren' => true,
                        'icon' => '<i class="bi bi-toggles menu-section-icon"></i>',
                    ]),
                    $sub
                )
            )
            ->render();
    }
}
