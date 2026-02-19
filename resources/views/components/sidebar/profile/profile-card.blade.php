<div class="sidebar-item has-submenu">
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
        <x-sidebar.sidebar-submenu class="d-flex flex-column gap-3" x-data="{ profileSubmenuTab: 'users' }">
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
                        />
                    @endif
                </div>
            </template>
        </x-sidebar.sidebar-submenu>
    </div>
</div>
