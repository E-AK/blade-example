<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Status extends Component
{
    private const VARIANTS = [
        'success' => [
            'text' => 'Работает',
            'color' => 'green',
            'rightIcon' => 'validation_check_circle',
        ],
        'error' => [
            'text' => 'Не работает',
            'color' => 'red',
            'rightIcon' => 'validation_alert',
        ],
        'attention' => [
            'text' => 'Остановлено',
            'color' => 'yellow',
            'rightIcon' => 'validation_warning',
        ],
        'info' => [
            'text' => 'Готов к работе',
            'color' => 'blue',
            'rightIcon' => 'validation_info',
        ],
        'pause' => [
            'text' => 'Остановлен',
            'color' => 'grey-3',
            'rightIcon' => 'validation_pause',
        ],
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $variant = 'success',
        public bool $hasRightIcon = false,
    ) {
        //
    }

    public function text(): string
    {
        return self::VARIANTS[$this->variant]['text'] ?? '';
    }

    public function colorClass(): string
    {
        return 'status-'.(self::VARIANTS[$this->variant]['color'] ?? 'grey-3');
    }

    public function icon(): string
    {
        return self::VARIANTS[$this->variant]['rightIcon'] ?? 'validation_pause';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.status');
    }
}
