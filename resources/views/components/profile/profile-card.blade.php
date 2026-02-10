<div class="sidebar-item has-submenu">
    <div>
        <div {{ $attributes->merge(['class' => 'profile-card d-flex flex-column gap-3 ' . $class]) }}>
            <x-profile.profile
                :title="$title"
                :subtitle="$subtitle"
                :badge="$badge"
                has-children
            />

            <x-profile.balance
                :balance="$balance"
            />
        </div>
    </div>

    <div class="sidebar-submenu-dropdown">
        <x-sidebar-submenu class="d-flex flex-column gap-3">
            <div class="d-flex gap-2">
                <x-profile.profile
                    :title="$title"
                    :subtitle="$subtitle"
                />
            </div>
            <div class=" gap-1">
                <x-menu-item is-submenu text="Настройки" href="#" />
                <x-menu-item is-submenu text="Уведомления" href="#" />
                <x-menu-item is-submenu text="Выйти из аккаунта" href="#" />
            </div>
        </x-sidebar-submenu>
    </div>
</div>
