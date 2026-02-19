<div
    class="sidebar-item has-submenu"
    :class="{ 'is-accounts-modal-open': accountsModalOpen || usersModalOpen }"
    x-data="{ profileSubmenuTab: 'users', accountsModalOpen: false, usersModalOpen: false }"
>
    <div>
        <div {{ $attributes->merge(['class' => 'profile-card d-flex flex-column gap-3 ' . $class]) }}>
            <x-sidebar.profile.profile
                :title="$title"
                :subtitle="$subtitle"
                :badge="$badge"
                has-children
            />

            <x-sidebar.profile.balance
                :balance="$balance"
            />
        </div>
    </div>

    <div class="sidebar-submenu-dropdown" style="gap: 12px">
        <x-sidebar.sidebar-submenu class="d-flex flex-column gap-3">
            <div class="d-flex gap-2">
                <x-sidebar.profile.profile
                    :title="$title"
                    :subtitle="$subtitle"
                />
            </div>
            <div class="d-flex flex-column gap-1">
                <x-sidebar.menu-item is-submenu text="Настройки" href="#" />
                <x-sidebar.menu-item is-submenu text="Уведомления" href="#" :badge-count="$badge" />
                <x-sidebar.menu-item is-submenu text="Выйти из аккаунта" href="#" />
            </div>
            <div
                class="d-flex flex-column gap-1 profile-list-section"
            >
                <div class="d-flex flex-row profile-dropdown-tab p5">
                    <button
                        type="button"
                        class="border-0 bg-transparent p-0 text-uppercase profile-dropdown-tab__btn"
                        :class="profileSubmenuTab === 'users' ? 'header-yellow' : 'header-grey'"
                        @click="profileSubmenuTab = 'users'"
                    >
                        Пользователи
                    </button>
                    <button
                        type="button"
                        class="border-0 bg-transparent p-0 text-uppercase profile-dropdown-tab__btn"
                        :class="profileSubmenuTab === 'accounts' ? 'header-yellow' : 'header-grey'"
                        @click="profileSubmenuTab = 'accounts'"
                    >
                        Аккаунты
                    </button>
                </div>
            </div>
            <template x-if="profileSubmenuTab === 'users'">
                <div class="d-flex flex-column gap-1">
                    @foreach($displayUsers() as $user)
                        <x-sidebar.menu-item
                                is-submenu
                                :active="$user['active']"
                                :text="$user['name']"
                                :href="$user['href']"
                                :trailing-icon="$user['active'] ? 'validation_check' : null"
                                is-account-item
                        />
                    @endforeach
                    @if($hasMoreUsers())
                        <x-sidebar.menu-item
                                is-submenu
                                is-list-action
                                text="Список всех пользователей"
                                as-button
                                x-on:click="usersModalOpen = true"
                        />
                    @endif
                </div>
            </template>
            <template x-if="profileSubmenuTab === 'accounts'">
                <div class="d-flex flex-column gap-1">
                    @foreach($displayAccounts() as $account)
                        <x-sidebar.menu-item
                                is-submenu
                                :active="$account['active']"
                                :text="$account['name']"
                                :href="$account['href']"
                                icon="actions_home"
                                :trailing-icon="$account['active'] ? 'validation_check' : null"
                                is-account-item
                        />
                    @endforeach
                    @if($hasMoreAccounts())
                        <x-sidebar.menu-item
                                is-submenu
                                is-list-action
                                text="Список всех аккаунтов"
                                icon="actions_list"
                                as-button
                                x-on:click="accountsModalOpen = true"
                        />
                    @endif
                </div>
            </template>
        </x-sidebar.sidebar-submenu>
    </div>

    <template x-if="accountsModalOpen">
        <x-modal
            :open="true"
            title="Мои аккаунты"
            width="780px"
            min-height="320px"
            :close-button-attributes="['x-on:click' => 'accountsModalOpen = false']"
            :overlay-attributes="['x-on:click.self' => 'accountsModalOpen = false']"
        >
            <div
                class="d-flex flex-column gap-4 accounts-modal-body"
                x-data="{ accountsModalFilter: 'all' }"
                @accounts-filter-changed="accountsModalFilter = $event.detail"
            >
                <x-button-toggle
                    class="accounts-modal-body__toggle button-toggle--fill align-self-stretch"
                    x-effect="$dispatch('accounts-filter-changed', selected)"
                >
                    @foreach($users as $user)
                        <x-button-toggle-item
                            name="accountsFilter"
                            :value="$user['name']"
                            :label="$user['name']"
                            selected="all"
                        />
                    @endforeach
                    <x-button-toggle-item
                        name="accountsFilter"
                        value="all"
                        label="Все учетные записи"
                        selected="all"
                    />
                </x-button-toggle>
                <div class="d-flex flex-column gap-1 accounts-modal-list">
                    @foreach($accounts as $account)
                        <a
                            href="{{ $account['href'] }}"
                            class="accounts-modal-row d-flex align-items-center text-decoration-none text-reset"
                            :class="{ 'accounts-modal-row--section': accountsModalFilter === 'all' }"
                            x-data="{ account: @js(array_merge($account, ['users' => $account['users'] ?? []])) }"
                            x-show.important="
                                accountsModalFilter === 'all' ||
                                (account.users ?? []).map(u => u.name).includes(accountsModalFilter)
                            "
                        >
                            <div class="accounts-modal-row__inner d-flex justify-content-between align-items-center gap-2 w-100">
                                <div class="d-flex flex-row gap-2">
                                    <div class="d-flex align-items-center gap-2 flex-grow-1 min-w-0">
                                    <span
                                            class="d-flex align-items-center justify-content-center flex-shrink-0 accounts-modal-row__icon {{ $account['active'] ? 'text-warning' : 'text-secondary' }}"
                                    >
                                        <x-icon name="actions_home" />
                                    </span>
                                        <span class="{{ $account['active'] ? 'fw-semibold' : '' }}">{{ $account['name'] }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0" x-show.important="accountsModalFilter === 'all'">
                                        @foreach($account['users'] ?? [] as $u)
                                            <x-tag
                                                    :text="$u['name']"
                                                    icon="left"
                                                    size="sm"
                                                    :left-icon="$u['type'] === 'owner' ? 'actions_crown' : 'actions_profile'"
                                                    :hoverable="false"
                                            />
                                        @endforeach
                                    </div>
                                </div>
                                @if($account['active'])
                                    <x-icon name="validation_check" class="flex-shrink-0 text-secondary ms-1" />
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </x-modal>
    </template>

    <template x-if="usersModalOpen">
        <x-modal
            :open="true"
            title="Учетные записи"
            width="560px"
            min-height="460px"
            :close-button-attributes="['x-on:click' => 'usersModalOpen = false']"
            :overlay-attributes="['x-on:click.self' => 'usersModalOpen = false']"
        >
            <div class="d-flex flex-column align-items-stretch users-modal-body">
                @php
                    $activeUser = collect($users)->firstWhere('active', true);
                    $otherUsers = collect($users)->filter(fn ($u) => !($u['active'] ?? false))->values()->all();
                @endphp
                @if($activeUser)
                    <x-user-card
                        :name="$activeUser['name']"
                        :email="$activeUser['email'] ?? 'vlad_ivanov@company.ru'"
                        :role="$activeUser['role'] ?? 'Администратор'"
                        tag-left-icon="actions_crown"
                        wrapper-class="users-modal-row users-modal-row--current rounded-3"
                    >
                        <x-slot:actions>
                            <x-button type="stroke" size="medium" icon-position="only" class="rounded-circle" :extra-attributes="['aria-label' => __('Settings')]">
                                <x-slot:icon>
                                    <x-icon name="actions_settings" :size="20" />
                                </x-slot:icon>
                            </x-button>
                            <x-button type="stroke" size="medium" icon-position="only" class="rounded-circle" :extra-attributes="['aria-label' => __('Log out')]">
                                <x-slot:icon>
                                    <x-icon name="actions_logout" :size="20" />
                                </x-slot:icon>
                            </x-button>
                        </x-slot:actions>
                    </x-user-card>
                @endif
                <span class="small text-uppercase users-modal-others-label">Другие учетные записи</span>
                <div class="users-modal-profiles-content d-flex flex-column">
                    @foreach($otherUsers as $user)
                        <x-user-card
                            :name="$user['name']"
                            :email="$user['email'] ?? 'vlad_ivanov@company.ru'"
                            :role="$user['role'] ?? 'Менеджер'"
                            :href="$user['href']"
                            wrapper-class="users-modal-row rounded-3 border"
                        />
                    @endforeach
                </div>
                <div class="pt-2">
                    <x-button type="string" size="medium" icon-position="left" class="text-secondary" href="#">
                        <x-slot:icon>
                            <x-icon name="actions_plus" :size="20" />
                        </x-slot:icon>
                        Добавить новую учетную запись
                    </x-button>
                </div>
            </div>
        </x-modal>
    </template>
</div>
