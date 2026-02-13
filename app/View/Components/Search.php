<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public function __construct(
        public string $size = 'md',
        public string $placeholder = '',
        public string $value = '',
        public bool $selected = false,
        public string $description = '',
        public array $tags = [],
        public bool $clearable = true,
        public string $class = '',
    ) {}

    public function wrapperClasses(): string
    {
        $classes = ['search-wrapper'];

        if ($this->selected) {
            $classes[] = 'state-selected';
        }

        if ($this->description) {
            $classes[] = 'has-description';
        }

        $classes[] = $this->class;

        return implode(' ', $classes);
    }

    public function searchClasses(): string
    {
        $classes = ['search-box'];

        $classes[] = "search-box-{$this->size}";

        if ($this->value !== '') {
            $classes[] = 'state-filled';
        }

        if ($this->selected) {
            $classes[] = 'state-selected';
        }

        if (! empty($this->tags)) {
            $classes[] = 'has-tags';
        }

        return implode(' ', $classes);
    }

    public function isInputMode(): bool
    {
        return $this->value === '' && empty($this->tags);
    }

    public function iconSize(): int
    {
        return $this->size === 'lg' ? 20 : 16;
    }

    public function leftIconColor(): string
    {
        if ($this->selected) {
            return 'grey-1'; // #666563
        }

        return 'grey-3'; // #C7C7C7 (для default/hover)
    }

    /**
     * Render the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search');
    }
}
