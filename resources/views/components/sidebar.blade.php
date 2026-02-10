<aside class="sidebar d-flex flex-column h-100 py-3 px-2 gap-4">

    <div class="sidebar-header d-flex flex-column gap-4">
        <div class="sidebar-logo px-2"></div>

        <x-menu-item
            as-button
            text="Свернуть меню"
            class="sidebar-toggle-btn"
            icon='<i class="bi bi-arrow-bar-left"></i>'
        />
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-item has-submenu">
            <x-menu-item
                    text="Настройки"
                    short-text="Наст-ки"
                    icon='<i class="bi bi-toggles"></i>'
                    :has-children="true"
            />

{{--            <div class="sidebar-submenu-dropdown">--}}
{{--                <x-sidebar-submenu>--}}
{{--                    <x-menu-item is-submenu text="Профиль" href="#" />--}}
{{--                    <x-menu-item is-submenu text="Безопасность" href="#" />--}}
{{--                    <x-menu-item is-submenu text="Уведомления" href="#" />--}}
{{--                </x-sidebar-submenu>--}}
{{--            </div>--}}
        </div>
    </nav>

    <div class="sidebar-footer-stack d-flex flex-column gap-2 mt-auto">
        <x-profile.profile-card
            title="TESt"
            subtitle="test t.s."
            badge="24"
        />

        <x-menu-item
            text="База знаний"
            short-text="База зн."
            href="#"
            icon='<i class="bi bi-book"></i>'
            class="menu-knowledge text-center"
        />
    </div>
</aside>
