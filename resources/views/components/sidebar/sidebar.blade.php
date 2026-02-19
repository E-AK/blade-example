<aside class="sidebar d-flex flex-column h-100 py-3 px-2 gap-4">
    <div class="sidebar-header d-flex flex-column gap-4">
        <div class="sidebar-logo d-flex justify-content-center px-2">
            <x-icon name="logo_sidebar_light" class="logo-expanded"/>
            <x-icon name="logo_sidebar_min" class="logo-collapsed"/>
        </div>

        <x-sidebar.menu-item
            as-button
            text="Свернуть меню"
            class="sidebar-toggle-btn"
            icon='menu_collapse'
        />
    </div>

    <nav class="sidebar-nav">
        @include('components.sidebar.partials.sidebar-tree', ['tree' => $sidebarTree])
    </nav>

    <div class="sidebar-footer-stack d-flex flex-column mt-auto">
        <x-sidebar.profile.profile-card
            title="ООО Сбис-Вятка"
            subtitle="Иванов В. В."
            badge="24"
            balance="1 00 000.00 ₽"
            :users="[
                ['name' => 'Иванов Василий Викторович', 'active' => true, 'href' => '#'],
                ['name' => 'Петрова Анна Сергеевна', 'active' => false, 'href' => '#'],
                ['name' => 'Сидоров Илья Валерьевич', 'active' => false, 'href' => '#'],
                ['name' => 'Козлова Мария Петровна', 'active' => false, 'href' => '#'],
                ['name' => 'Новиков Алексей Иванович', 'active' => false, 'href' => '#'],
            ]"
            :accounts="[
                ['name' => 'ООО Сбис-Вятка', 'active' => true, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner'], ['name' => 'Петрова Анна Сергеевна', 'type' => 'member']]],
                ['name' => 'ООО Нутриотика', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
                ['name' => 'ИП Васильев Петр Ильич', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
                ['name' => 'ООО Рога и копыта', 'active' => false, 'href' => '#', 'users' => [['name' => 'Иванов Василий Викторович', 'type' => 'owner']]],
                ['name' => 'ИП Сидоров А. А.', 'active' => false, 'href' => '#', 'users' => [['name' => 'Петрова Анна Сергеевна', 'type' => 'member']]],
            ]"
        />

        <x-sidebar.menu-item
            text="База знаний"
            short-text="База зн."
            href="#"
            icon='menu_knowledge'
            class="menu-knowledge text-center"
        />
    </div>
</aside>
