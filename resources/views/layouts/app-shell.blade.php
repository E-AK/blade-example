<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.scss'])
    @endif
</head>
<body>
<div class="app-layout">
    <x-sidebar.sidebar />
    <div class="d-flex flex-column main-scroll">
        <x-topbar
            :header-info-text="$headerInfoText ?? ''"
            :header-title-text="$headerTitleText ?? ''"
            :show-current-page-in-breadcrumbs="$showCurrentPageInBreadcrumbs ?? false"
            :show-last-part="$showLastBreadcrumbPart ?? false"
            :last-breadcrumb-url="$lastBreadcrumbUrl ?? null"
        >
            @yield('topbar_buttons')
        </x-topbar>
        @yield('content_wrapper')
    </div>
</div>
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/js/app.js'])
@endif
</body>
</html>
