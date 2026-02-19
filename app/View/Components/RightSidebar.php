<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RightSidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $open = false,
        public ?string $title = null,
        public ?string $titleId = null,
        public array $closeButtonAttributes = [],
        public array $overlayAttributes = []
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.right-sidebar');
    }
}
