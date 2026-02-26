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
                <x-input name="name" placeholder="Название" />
                <x-select
                        name="section"
                        placeholder="Раздел"
                        :options="[1 => 1]"
                />
                <x-select
                        name="period-start"
                        placeholder="Собирать данные с"
                        left-icon="actions_calendar"
                        :options="[1 => 1]"
                />
                <x-select
                        name="period-start"
                        placeholder="Собирать данные по"
                        left-icon="actions_calendar"
                        :options="[1 => 1]"
                />
                <p class="p4 text-grey-1" style="font-size: 14px !important;">Рекомендуемый максимальный интервал данных - 12 месяцев</p>
                <x-slot:footer>
                    <x-button type="main" size="large">Добавить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
