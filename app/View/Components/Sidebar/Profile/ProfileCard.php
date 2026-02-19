<?php

declare(strict_types=1);

namespace App\View\Components\Sidebar\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileCard extends Component
{
    /**
     * @param  array<int, array{name: string, active: bool, href: string}>  $users
     * @param  array<int, array{name: string, active: bool, href: string}>  $accounts
     */
    public function __construct(
        public string $title,
        public string $subtitle,
        public ?string $badge = null,
        public string $balance = '0.00',
        public string $class = '',
        public array $users = [],
        public array $accounts = [],
    ) {
        //
    }

    public function usersCount(): int
    {
        return count($this->users);
    }

    /**
     * @return array<int, array{name: string, active: bool, href: string}>
     */
    public function displayUsers(): array
    {
        return array_slice($this->users, 0, 4);
    }

    public function hasMoreUsers(): bool
    {
        return $this->usersCount() > 4;
    }

    public function accountsCount(): int
    {
        return count($this->accounts);
    }

    /**
     * @return array<int, array{name: string, active: bool, href: string}>
     */
    public function displayAccounts(): array
    {
        return array_slice($this->accounts, 0, 4);
    }

    public function hasMoreAccounts(): bool
    {
        return $this->accountsCount() > 4;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.profile.profile-card');
    }
}
