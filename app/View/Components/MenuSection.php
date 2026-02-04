<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuSection extends Component
{
    public function __construct(
        public string $text,
        public ?string $icon = null,
        public bool $active = false,
        public bool $hasChildren = false,
        public string $href = '#',
        public string $class = ''
    ) {}

    public function classes(): string
    {
        $base = [
            'menu-section',
            $this->active ? 'active' : '',
            $this->hasChildren ? 'has-children' : ''
        ];

        return implode(' ', array_filter($base)) . ' ' . $this->class;
    }

    public function render(): View|Closure|string
    {
        return view('components.menu-section');
    }
}
