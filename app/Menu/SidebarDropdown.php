<?php

namespace App\Menu;

use Illuminate\Support\Facades\Blade;
use Spatie\Menu\Item;
use Spatie\Menu\Laravel\Menu;

class SidebarDropdown implements Item
{
    public function __construct(
        protected Item $trigger,
        protected Menu $submenu
    ) {}

    public static function make(Item $trigger, Menu $submenu): self
    {
        return new self($trigger, $submenu);
    }

    public function render(): string
    {
        return Blade::render(
            <<<'BLADE'
<div x-data="{ open: false }" class="sidebar-item position-relative">
    
    <div @click="open = !open">
        {!! $trigger !!}
    </div>

    <div x-show="open" class="sidebar-submenu-dropdown" @click.outside="open = false">
        {!! $submenu !!}
    </div>
</div>
BLADE,
            [
                'trigger' => $this->trigger->render(),
                'submenu' => $this->submenu->render(),
            ]
        );
    }

    public function isActive(): bool
    {
        return false;
    }
}
