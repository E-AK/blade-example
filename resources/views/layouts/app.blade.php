@use(App\Menu\SidebarMenu)
@use (Illuminate\Support\Facades\Blade)
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
        <div class="sidebar-header flex-column">
            <div class="sidebar-logo">
                <x-icon name="logo_sidebar" class="logo-expanded" x-show="!collapsed"/>
                <x-icon name="logo_sidebar_min" class="logo-collapsed" x-show="collapsed"/>
            </div>

            <x-menu-section
                    as-button
                    text="Свернуть меню"
                    x-show="!collapsed"
                    x-on:click="collapsed = true"
                    class="sidebar-toggle-btn"
                    icon='<i class="bi bi-arrow-bar-left"></i>'
            />

            <x-menu-section
                    as-button
                    text=""
                    x-show="collapsed"
                    x-on:click="collapsed = false"
                    class="sidebar-toggle-btn"
                    icon='<i class="bi bi-arrow-bar-right"></i>'
            />
        </div>

        <nav class="sidebar-nav">
            {!! SidebarMenu::render() !!}
        </nav>

        <div class="sidebar-footer-stack">
            <x-profile-card />

            <x-menu-section
                    text="База знаний"
                    href="#"
                    icon='<i class="bi bi-book"></i>'
                    class="menu-knowledge"
            />
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
