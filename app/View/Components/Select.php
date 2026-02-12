<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $text = null,
        public ?string $value = null,
        public ?string $label = null,
        public ?string $leftIcon = null,
        public string $rightIcon = 'arrow_chevron_down',
        public string $type = 'main',
        public ?string $state = null,
        public bool $disabled = false,
        public ?string $error = null,
        public bool $cursor = false,
        public array $options = [],
        public ?string $description = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
