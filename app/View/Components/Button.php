<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $variant = 'main',
        public string $size = 'md',
        public bool $outline = false,
        public bool $block = false,
        public bool $pill = false,
        public bool $disabled = false,
        public bool $loading = false,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public string $type = 'button',
    ) {}

    public function classes(): string
    {
        $base = ['btn'];

        $variants = [
            'main' => 'btn-primary',
            'secondary' => 'btn-secondary',
            'danger' => 'btn-danger',
            'stroke' => 'btn-outline-primary',
            'string' => 'btn-link',
            'danger-string' => 'btn-link text-danger',
        ];

        $sizes = [
            'sm' => 'btn-sm',
            'md' => '',
            'lg' => 'btn-lg',
        ];

        $base[] = $variants[$this->variant] ?? $variants['main'];
        $base[] = $sizes[$this->size] ?? '';
        $base[] = $this->block ? 'w-100' : '';
        $base[] = $this->pill ? 'rounded-pill' : '';

        return implode(' ', array_filter($base));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
