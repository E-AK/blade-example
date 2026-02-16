<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toast extends Component
{
    private const STATES = [
        'success' => ['icon' => 'validation_check_circle'],
        'error' => ['icon' => 'validation_alert'],
        'attention' => ['icon' => 'validation_warning'],
        'info' => ['icon' => 'validation_info'],
    ];

    public function __construct(
        public string $state = 'info',
        public ?string $title = null,
        public string $class = ''
    ) {}

    public function stateConfig(): array
    {
        return self::STATES[$this->state] ?? self::STATES['info'];
    }

    public function iconName(): string
    {
        return $this->stateConfig()['icon'];
    }

    public function hasTitle(): bool
    {
        return $this->title !== null && $this->title !== '';
    }

    public function classes(): string
    {
        $base = ['toast-custom', 'toast-custom--'.$this->state];

        if ($this->class !== '') {
            $base[] = $this->class;
        }

        return implode(' ', array_filter($base));
    }

    public function render(): View|Closure|string
    {
        return view('components.toast');
    }
}
