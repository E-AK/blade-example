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
     * @param  array<int, array{name: string, active: bool, href: string, users?: array<int, array{name: string, type: string}>}>  $accounts
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
        $this->users = $this->users ?: $this->staticUsers();
        $this->accounts = $this->accounts ?: $this->staticAccounts();
    }

    /**
     * Static users for testing the "My Accounts" modal filter.
     *
     * @return array<int, array{name: string, active: bool, href: string}>
     */
    private function staticUsers(): array
    {
        return [
            ['name' => 'Иванов Василий Викторович', 'active' => true, 'href' => '#'],
            ['name' => 'Петрова Анна Сергеевна', 'active' => false, 'href' => '#'],
            ['name' => 'Сидоров Илья Валерьевич', 'active' => false, 'href' => '#'],
            ['name' => 'Козлова Мария Петровна', 'active' => false, 'href' => '#'],
            ['name' => 'Новиков Алексей Иванович', 'active' => false, 'href' => '#'],
        ];
    }

    /**
     * Static accounts with user associations for testing the "My Accounts" modal.
     *
     * @return array<int, array{name: string, active: bool, href: string, users: array<int, array{name: string, type: string}>}>
     */
    private function staticAccounts(): array
    {
        return [
            ['name' => 'ООО Сбис-Вятка', 'active' => true, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner'], ['name' => 'Петрова Анна Сергеевна', 'type' => 'member']]],
            ['name' => 'ООО Нутриотика', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
            ['name' => 'ИП Васильев Петр Ильич', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
            ['name' => 'ООО Рога и копыта', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
            ['name' => 'ИП Сидоров А. А.', 'active' => false, 'href' => '#', 'users' => [['name' => 'Петрова Анна Сергеевна', 'type' => 'member']]],
            ['name' => 'ООО Тест-Фильтр', 'active' => false, 'href' => '#', 'users' => [['name' => 'Сидоров Илья Валерьевич', 'type' => 'owner'], ['name' => 'Козлова Мария Петровна', 'type' => 'member']]],
        ];
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
     * @return array<int, array{name: string, active: bool, href: string, users?: array<int, array{name: string, type: string}>}>
     */
    public function accountsWithUsers(): array
    {
        return array_map(
            fn (array $account): array => [
                'name' => $account['name'],
                'active' => $account['active'],
                'href' => $account['href'],
                'users' => $account['users'] ?? [],
            ],
            $this->accounts
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.profile.profile-card');
    }
}
