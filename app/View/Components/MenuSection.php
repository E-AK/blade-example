<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuSection extends Component
{
    public function __construct(
        public string $text = '',
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
        $classes = ['menu-section'];

        if ($this->hasChildren) {
            $classes[] = 'has-children';
        }

        if ($this->isNew) {
            $classes[] = 'menu-section--new';
        }

        if ($this->isAction) {
            $classes[] = 'menu-section--action';
        }

        if ($this->isSubmenu) {
            $classes[] = 'menu-section--submenu';
        }

        return implode(' ', $classes);
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar.menu-section');
    }
}
