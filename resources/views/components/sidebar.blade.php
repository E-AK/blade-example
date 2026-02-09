<aside class="sidebar">
    <div class="sidebar-header flex-column">
        <div class="sidebar-logo">

        </div>

        <x-menu-item
            as-button
            text="Свернуть меню"
            class="sidebar-toggle-btn"
            icon='<i class="bi bi-arrow-bar-left"></i>'
        />
    </div>

    <nav class="sidebar-nav">

    </nav>

    <div class="sidebar-footer-stack">
        <x-profile.profile-card
                title="TESt"
                subtitle="test t.s."
                badge="24"
        />

        <x-menu-item
            text="База знаний"
            href="#"
            icon='<i class="bi bi-book"></i>'
            class="menu-knowledge"
        />
    </div>
</aside>
