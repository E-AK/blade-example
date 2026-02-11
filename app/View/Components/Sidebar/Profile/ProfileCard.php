<?php

declare(strict_types=1);

namespace App\View\Components\Sidebar\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $subtitle,
        public ?string $badge = null,
        public string $balance = '0.00',
        public string $class = ''
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.profile.profile-card');
    }
}
