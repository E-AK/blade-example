<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $open = false,
        public string $size = 'small',
        public ?string $title = null,
        public ?string $titleId = null,
        public array $closeButtonAttributes = [],
        public array $overlayAttributes = [],
        public ?string $width = null,
        public ?string $minHeight = null
    ) {}

    public function dialogId(): string
    {
        return $this->titleId ?? 'modal-title-'.uniqid('', true);
    }

    public function sizeClass(): string
    {
        return match ($this->size) {
            'large' => 'modal--large',
            default => 'modal--small',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
