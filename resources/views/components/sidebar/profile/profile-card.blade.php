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

    <div class="sidebar-submenu-dropdown">
        <x-sidebar.sidebar-submenu class="d-flex flex-column gap-3">
            <div class="d-flex gap-2">
                <x-sidebar.profile.profile
                    :title="$title"
                    :subtitle="$subtitle"
                />
            </div>
            <div class=" gap-1">
                <x-sidebar.menu-item is-submenu text="Настройки" href="#" />
                <x-sidebar.menu-item is-submenu text="Уведомления" href="#" />
                <x-sidebar.menu-item is-submenu text="Выйти из аккаунта" href="#" />
            </div>
        </x-sidebar.sidebar-submenu>
    </div>
</div>
