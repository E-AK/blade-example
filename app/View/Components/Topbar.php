<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Navigation\Facades\Navigation;

class Topbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $headerInfoText = null,
        public string $headerTitleText = '',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $breadcrumbs = Navigation::make()->breadcrumbs();

        $headerInfoText = $this->headerInfoText;
        if (! empty($breadcrumbs)) {
            $last = end($breadcrumbs);
            $headerInfoText = $last['title'] ?? $headerInfoText;
        }

        return view('components.topbar', [
            'breadcrumbs' => $breadcrumbs,
            'headerInfoText' => $headerInfoText,
        ]);
    }
}
