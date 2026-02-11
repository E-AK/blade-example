<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body>
<div class="app-layout">
    <x-sidebar.sidebar />
    <div class="d-flex flex-column main-scroll">
        <!-- TODO: to topbar component -->
        <div class="d-flex justify-content-between shadow topbar">
            <div class="d-flex flex-column gap-1">
                <span>sadfsf</span>
                <h1 class="workspace-container-header-title">
                    Test
                </h1>
            </div>
            <div class="d-flex gap-5 justify-content-center align-self-center">
                <x-button text="Информация" variant="string" size="lg"/>
                <x-button text="Test" size="lg"/>
                <x-button text="Действия" variant="secondary" size="lg"/>
            </div>
        </div>
        <div class="grid shadow content gap-2.5">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
