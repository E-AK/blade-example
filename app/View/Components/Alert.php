<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    private const STATES = [
        'success' => ['icon' => 'validation_check_circle'],
        'error' => ['icon' => 'validation_alert'],
        'attention' => ['icon' => 'validation_warning'],
        'info' => ['icon' => 'validation_info'],
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $state = 'success',
        public ?string $title = null,
        public string $class = ''
    ) {}

    public function stateConfig(): array
    {
        return self::STATES[$this->state] ?? self::STATES['success'];
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
        $base = ['alert', 'alert--'.$this->state];

        if ($this->class !== '') {
            $base[] = $this->class;
        }

        return implode(' ', array_filter($base));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
