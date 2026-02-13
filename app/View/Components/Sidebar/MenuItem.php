<?php

declare(strict_types=1);

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text = '',
        public string $shortText = '',
        public ?string $icon = null,
        public bool $active = false,
        public bool $hasChildren = false,
        public string $href = '#',
        public string $class = '',
        public bool $asButton = false,
        public bool $isNew = false,
        public bool $isAction = false,
        public bool $isSubmenu = false,
    ) {}

    public function classes(): string
    {
        $classes = ['menu-item'];

        if ($this->hasChildren) {
            $classes[] = 'has-children';
        }

        if ($this->isNew) {
            $classes[] = 'menu-item--new';
        }

        if ($this->isAction) {
            $classes[] = 'menu-item--action';
        }

        if ($this->isSubmenu) {
            $classes[] = 'menu-item--submenu overflow-hidden';
        }

        $classes[] = $this->class;

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.menu-item');
    }
}
