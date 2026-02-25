@php
    $headerTitleText = 'Витрины данных';
@endphp

@extends('layouts.app')

@section('topbar_buttons')
    <x-button
        type="main"
        size="large"
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'data-showcases-open-add-sidebar\'))']"
    >
        Добавить витрину данных
    </x-button>
@endsection

@section('content')
    <div
        class="data-showcases-page"
        x-data="{ addShowcaseSidebarOpen: false }"
        @data-showcases-open-add-sidebar.window="addShowcaseSidebarOpen = true"
    >
        <x-table
            search-class="data-showcases-search"
            search-placeholder="Поиск"
            :data-table="$dataTable"
        />

        <template x-if="addShowcaseSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Добавить витрину данных"
                :close-button-attributes="['x-on:click' => 'addShowcaseSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'addShowcaseSidebarOpen = false']"
            >
                <div class="d-flex flex-column" style="gap: 12px">
                    <p class="p4 text-secondary mb-0">Форма добавления витрины данных.</p>
                </div>
                <x-slot:footer>
                    <x-button type="main" size="large">Сохранить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
