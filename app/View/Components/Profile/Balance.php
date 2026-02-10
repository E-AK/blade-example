<?php

declare(strict_types=1);

namespace App\View\Components\Profile;

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
        public string $paymentRoute = '/payment',
        public string $class = ''
    ) {
        //
    }

    public function classes(): string
    {
        $base = ['text-decoration-none profile-balance d-flex align-items-center justify-content-between'];

        $base[] = self::VARIANTS[$this->variant] ?? self::VARIANTS['yellow'];

        return implode(' ', array_filter($base)).' '.$this->class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.balance');
    }
}
