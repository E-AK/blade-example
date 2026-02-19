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
        <div class="sidebar-item has-submenu">
            <x-sidebar.menu-item
                    text="Подключения"
                    short-text="Подкл-я"
                    icon="menu_connections"
                    :has-children="true"
            />

            <div class="sidebar-submenu-dropdown">
                <x-sidebar.sidebar-submenu>
                    <x-sidebar.menu-item is-submenu text="Сбис" href="#" />
                    <x-sidebar.menu-item is-submenu text="Хранилище данных" href="#" />
                    <x-sidebar.menu-item is-submenu text="Wazzup 24" href="#" />
                </x-sidebar.sidebar-submenu>
            </div>
        </div>

        <div class="sidebar-item has-submenu">
            <x-sidebar.menu-item
                text="Сбор информации"
                short-text="Сбор ин-"
                icon="menu_get_info"
                :has-children="true"
            />

            <div class="sidebar-submenu-dropdown">
                <x-sidebar.sidebar-submenu>
                    <x-sidebar.menu-item is-submenu text="Пользовательские таблицы" href="#" />
                    <x-sidebar.menu-item is-submenu text="Сотрудники" href="#" />
                    <x-sidebar.menu-item is-submenu text="Лиды" href="#" />
                    <x-sidebar.menu-item is-submenu text="События" href="#" />
                    <x-sidebar.menu-item is-submenu text="Исходящие" href="#" />
                    <x-sidebar.menu-item is-submenu text="Реализация" href="#" />
                    <x-sidebar.menu-item is-submenu text="Обращения" href="#" />
                    <x-sidebar.menu-item is-submenu text="Наряды" href="#" />
                    <x-sidebar.menu-item is-submenu text="Звонки" href="#" />
                    <x-sidebar.menu-item is-submenu text="Номенклатура" href="#" />
                    <x-sidebar.menu-item is-submenu text="Виды работ" href="#" />
                    <x-sidebar.menu-item is-submenu text="Чеки" href="#" />
                    <x-sidebar.menu-item is-submenu text="Настройка импорта данных" href="#" />
                    <x-sidebar.menu-item is-submenu text="Витрина данных" href="#" />
                </x-sidebar.sidebar-submenu>
            </div>
        </div>

        <div class="sidebar-item has-submenu">
            <x-sidebar.menu-item
                text="Сервисы"
                short-text="Сервисы"
                icon="menu_services"
                :has-children="true"
            />

            <div class="sidebar-submenu-dropdown">
                <x-sidebar.sidebar-submenu>
                    <x-sidebar.menu-item is-submenu text="Сервис сокращения ссылок" href="#" />
                    <x-sidebar.menu-item is-submenu text="Списание в пересорт" href="#" />
                    <x-sidebar.menu-item is-submenu text='Отчет "Потребности"' href="#" />
                    <x-sidebar.menu-item is-submenu text="Инвентаризация" href="#" />
                    <x-sidebar.menu-item is-submenu text="Менеджер паролей" href="#" />
                    <x-sidebar.menu-item is-submenu text="WordPress" href="#" />
                    <x-sidebar.menu-item is-submenu text="Интеграция с liko" href="#" />
                    <x-sidebar.menu-item is-submenu text="Отправка опросного лица" href="#" />
                    <x-sidebar.menu-item is-submenu text="Интеграция с поставщиками шин" href="#" />
                    <x-sidebar.menu-item is-submenu text="Номенклатура" href="#" />
                    <x-sidebar.menu-item is-submenu text="Виды работ" href="#" />
                    <x-sidebar.menu-item is-submenu text="Чеки" href="#" />
                    <x-sidebar.menu-item is-submenu text="Настройка импорта данных" href="#" />
                    <x-sidebar.menu-item is-submenu text="Витрина данных" href="#" />
                </x-sidebar.sidebar-submenu>
            </div>
        </div>

        <x-sidebar.menu-item
            text="Цепочки событий"
            short-text="Цепочки"
            icon="menu_chain"
        />

        <x-sidebar.menu-item
            text="Отчеты"
            short-text="Отчеты"
            icon="menu_report"
        />

        <x-sidebar.menu-item
            text="Планирование"
            short-text="План-е"
            icon="menu_planning"
        />

        <div class="sidebar-item has-submenu">
            <x-sidebar.menu-item
                text="Настройки"
                short-text="Наст-ки"
                icon='menu_settings'
                :has-children="true"
            />

            <div class="sidebar-submenu-dropdown">
                <x-sidebar.sidebar-submenu>
                    <x-sidebar.menu-item is-submenu text="Настройки аккаунта" href="#" />
                    <x-sidebar.menu-item is-submenu text="Настройка вебхуков" href="#" />
                    <x-sidebar.menu-item is-submenu text="Управление аккаунтами" href="#" />
                </x-sidebar.sidebar-submenu>
            </div>
        </div>

        <x-sidebar.menu-item
            text="Аккаунты"
            short-text="Аккаунты"
            href="/settings/account"
            icon="menu_accounts"
            has-children
        />
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
                ['name' => 'ООО Сбис-Вятка', 'active' => true, 'href' => '#'],
                ['name' => 'ООО Нутриотика', 'active' => false, 'href' => '#'],
                ['name' => 'ИП Васильев Петр Ильич', 'active' => false, 'href' => '#'],
                ['name' => 'ООО Рога и копыта', 'active' => false, 'href' => '#'],
                ['name' => 'ИП Сидоров А. А.', 'active' => false, 'href' => '#'],
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
