<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{
    public function __construct(
        public string $name,
        public string $email = '',
        public string $role = 'Менеджер',
        public string $tagLeftIcon = 'actions_profile',
        public ?string $href = null,
        public string $wrapperClass = 'user-card',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.user-card');
    }
}
