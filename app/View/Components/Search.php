<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    private const SIZES = [
        'md' => '',
        'lg' => 'search-box-lg',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $placeholder = '',
        public string $size = 'md',
        public string $description = '',
        public string $class = ''
    ) {
        //
    }

    public function classes(): string
    {
        $base = ['btn'];

        $base[] = self::SIZES[$this->size] ?? '';

        return implode(' ', array_filter($base)).' '.$this->class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search');
    }
}
