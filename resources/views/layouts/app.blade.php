<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body>
<div class="app-layout">
    <x-sidebar.sidebar />
    <div class="d-flex flex-column main-scroll">
        <x-topbar
            show-info-button
            show-summary-button
            show-action-button
            :summary-button-text="$summaryButtonText"
            :header-info-text="$headerInfoText"
            :header-title-text="$headerTitleText"
        />
        <div class="d-flex shadow content gap-2.5">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
