@use(App\Helpers\SidebarMenu)

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.scss', 'resources/js/app.js'])
        @endif
    </head>

    <body>
        <div class="app-layout">
            <aside class="sidebar">
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
