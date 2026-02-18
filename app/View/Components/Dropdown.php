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
     * @param  array<string, string|array{label: string, tag?: array}>  $options  Option value => label or option value => [label, tag?] (for multiselect)
     * @param  array<int, string>  $selected  Selected values (for multiselect)
     */
    public function __construct(
        public array $items = [],
        public array $options = [],
        public array $selected = [],
        public bool $forMultiselect = false,
        public string $id = 'dropdown'
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown');
    }
}
