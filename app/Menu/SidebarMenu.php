<?php

declare(strict_types=1);

namespace App\Menu;

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
                    'asButton' => true,
                    'hasChildren' => true,
                    'icon' => '<i class="bi bi-toggles menu-section-icon"></i>',
                ]),
                function (Menu $menu) {
                    $menu
                        ->addClass('sidebar-menu list-unstyled mb-0')
                        ->setActiveFromRequest()
                        ->add(
                            MenuSection::make('Управление аккаунтами', [
                                'href'      => route('settings.account'),
                                'isSubmenu' => true,
                            ])
                        );
                }
            )
            ->render();
    }
}
