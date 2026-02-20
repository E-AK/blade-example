<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  array<int, array{separator?: bool, label?: string, sublabel?: string, icon?: string, iconName?: string, state?: string, checked?: bool, url?: string|null}>  $items
     */
    public function __construct(
        public array $items = [],
        public bool $actions = false,
        public string $class = ''
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown');
    }
}
