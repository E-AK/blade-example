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
     * @param  array<int, array{label: string, state?: string, icon?: string, sublabel?: string, iconName?: string, separator?: bool, checked?: bool, url?: string, ...}>  $items  Menu items (for action dropdown)
     * @param  array<string, string|array{label: string, tag?: array}>  $options  Option value => label (for multiselect / select)
     * @param  array<int, string>  $selected  Selected values (for multiselect)
     * @param  bool  $forMultiselect  Render options as multiselect listbox
     * @param  bool  $forSelect  Render options as select dropdown (single choice, works with select.js)
     * @param  bool  $forActionCell  Render for actions-cell (e.g. sbis row actions); merges attributes like @click.stop
     * @param  bool  $actions  Use Medium (500) font for item labels (dropdowns with actions, not selections)
     */
    public function __construct(
        public array $items = [],
        public array $options = [],
        public array $selected = [],
        public bool $forMultiselect = false,
        public bool $forSelect = false,
        public bool $forActionCell = false,
        public bool $actions = true,
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
