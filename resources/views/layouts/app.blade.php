@use(App\Menu\SidebarMenu)

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @endif
</head>

<body>
<div class="app-layout">
    <aside
        id="sidebar"
        class="sidebar"
        x-data="{ collapsed: false }"
        :class="{ 'is-collapsed': collapsed }"
    >
        <div class="sidebar-inner d-flex flex-column">
            <div class="px-3 py-3 d-flex align-items-center justify-content-between">
                <div class="sidebar-logo">
                    <x-icon
                        name="logo_sidebar"
                        class="logo-expanded"
                        x-show="!collapsed"
                    />
                    <x-icon
                        name="logo_sidebar_min"
                        class="logo-collapsed"
                        x-show="collapsed"
                    />
                </div>

                <div>
                    <button
                        type="button"
                        class="sidebar-toggle btn btn-sm btn-outline-light"
                        @click="collapsed = !collapsed"
                        :aria-label="collapsed ? 'Развернуть меню' : 'Свернуть меню'"
                    >
                        <i
                            class="bi"
                            :class="collapsed ? 'bi-arrow-bar-right' : 'bi-arrow-bar-left'"
                        ></i>
                    </button>
                </div>
            </div>

            <nav class="sidebar-nav flex-grow-1 overflow-hidden">
                {!! SidebarMenu::render() !!}
            </nav>

            <div class="footer mt-auto py-3 px-3 pb-3">
                <div class="sidebar-account mb-3">
                    <div class="sidebar-account-main d-flex align-items-center gap-2">
                        <div class="sidebar-avatar position-relative">
                            <div class="avatar-circle"></div>
                            <span class="avatar-badge">24</span>
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <div class="account-name l2 text-truncate">
                                ООО Сбис-Вятка
                            </div>
                            <div class="account-user text-truncate l3">
                                Иванов В. В.
                            </div>
                        </div>

                        <i class="bi bi-chevron-right text-muted"></i>
                    </div>

                    <div class="sidebar-balance mt-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-wallet2 text-warning"></i>
                            <span>Баланс: 100 000.00 ₽</span>
                        </div>

                        <button class="btn btn-sm btn-warning rounded-circle">
                            +
                        </button>
                    </div>
                </div>

                <a href="#" class="sidebar-knowledge d-flex align-items-center gap-2">
                    <i class="bi bi-book"></i>
                    <span class="sidebar-knowledge-text b1">База знаний</span>
                </a>

            </div>
        </div>
    </aside>

    <main class="main-area">
        <div class="main-scroll">
            <x-topbar
                    :title="$title ?? null"
                    :title-url="$titleUrl ?? null"
                    :create-label="$createLabel ?? null"
            />

            <div class="container-xl py-4">
                @yield('content')
            </div>
        </div>
    </main>
</div>
</body>
</html>
