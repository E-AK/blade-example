<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Balance extends Component
{
    private const VARIANTS = [
        'yellow' => 'yellow',
        'red' => 'red',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $variant = 'yellow',
        public string $balance = '0.00',
        public string $class = ''
    )
    {
        //
    }

    public function classes(): string
    {
        $base = ['profile-balance d-flex align-items-center justify-content-between px-2 py-1 gap-2 rounded-2'];

        // variant
        $base[] = self::VARIANTS[$this->variant] ?? self::VARIANTS['yellow'];

        return implode(' ', array_filter($base)) . ' ' . $this->class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.profile.balance');
    }
}
