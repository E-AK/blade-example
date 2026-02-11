<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $headerInfoText = '',
        public string $headerTitleText = '',
        public bool $showInfoButton = false,
        public string $infoButtonText = 'Информация',
        public bool $showSummaryButton = false,
        public string $summaryButtonText = '',
        public bool $showActionButton = false,
        public string $actionButtonText = 'Действия',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.topbar');
    }
}
