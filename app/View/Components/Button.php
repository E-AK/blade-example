<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * @param  array<string, mixed>  $extraAttributes
     */
    public function __construct(
        public string $type = 'main',
        public string $size = 'medium',
        public bool $disabled = false,
        public string $iconPosition = 'none',
        public bool $stretch = false,
        public string $rounded = 'full',
        public ?string $href = null,
        public array $extraAttributes = []
    ) {}

    public function tag(): string
    {
        return $this->href !== null ? 'a' : 'button';
    }

    public function typeClass(): string
    {
        $type = in_array($this->type, ['main', 'secondary', 'stroke', 'danger', 'string', 'danger-string'], true)
            ? $this->type
            : 'main';

        return 'btn btn--'.$type;
    }

    public function sizeClass(): string
    {
        $size = in_array($this->size, ['large', 'medium', 'small'], true) ? $this->size : 'medium';

        return 'btn--'.$size;
    }

    public function iconClass(): string
    {
        if ($this->iconPosition === 'none') {
            return '';
        }

        return in_array($this->iconPosition, ['left', 'right', 'only'], true)
            ? 'btn--icon-'.$this->iconPosition
            : '';
    }

    public function roundedClass(): string
    {
        return $this->rounded === 'square' ? 'btn--rounded-square' : '';
    }

    public function classList(): string
    {
        return trim(implode(' ', array_filter([
            'btn',
            $this->typeClass(),
            $this->sizeClass(),
            $this->iconClass(),
            $this->roundedClass(),
            $this->stretch ? 'btn--stretch' : '',
            $this->disabled ? 'btn--disabled' : '',
        ])));
    }

    /**
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return array_merge(parent::data(), [
            'classList' => $this->classList(),
        ]);
    }

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
