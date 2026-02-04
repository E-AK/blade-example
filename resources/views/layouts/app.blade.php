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
    <aside id="sidebar" class="sidebar-menu d-flex flex-column flex-shrink-0 p-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fs-5 fw-semibold text-white">ТАВИАТ PRO</span>
        </div>
        <x-button
                variant="string"
                :icon-left='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path d="M5.22 7.47a.749.749 0 0 0 0 1.06l3.75 3.75a.749.749 0 1 0 1.06-1.06L7.561 8.75h6.689a.75.75 0 0 0 0-1.5H7.561l2.469-2.47a.749.749 0 1 0-1.06-1.06L5.22 7.47ZM3 3.75a.75.75 0 0 0-1.5 0v8.5a.75.75 0 0 0 1.5 0v-8.5Z"></path></svg>
SVG
'
        >
            СВЕРНУТЬ МЕНЮ
        </x-button>

        {!! SidebarMenu::render() !!}

    </aside>

    <div class="main-area d-flex flex-column min-vh-100">
        <nav class="topbar flex-shrink-0">
            <x-topbar
                    :title="$title ?? null"
                    :title-url="$titleUrl ?? null"
                    :create-label="$createLabel ?? null"
            />
        </nav>

        <main class="main-content flex-fill d-flex px-4 pb-4">
            <div class="content-card flex-fill bg-white rounded-4 shadow-sm p-4 overflow-auto">
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>
