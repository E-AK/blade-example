@php
    $headerTitleText = 'Просмотр таблицы';
@endphp

@extends('layouts.app')

@section('topbar_buttons')
    <x-button
        type="main"
        size="large"
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'custom-table-add-row-open\'))']"
    >
        Добавить строку
    </x-button>
@endsection

@section('content')
    <div
        class="custom-tables-show-page"
        x-data="{ addRowSidebarOpen: false }"
        @custom-table-add-row-open.window="addRowSidebarOpen = true"
    >
        <x-table
            search-class="custom-table-data-search"
            search-placeholder="Поиск"
            :data-table="$dataTable"
        />

        <template x-if="addRowSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Добавить строку"
                :close-button-attributes="['x-on:click' => 'addRowSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'addRowSidebarOpen = false']"
            >
                <div class="d-flex flex-column" style="gap: 12px;">
                    <x-input name="name" placeholder="test" />
                    <div class="d-flex flex-column p4 text-grey-1" style="font-size: 14px !important; gap: normal;">
                        <p>Тип данных – INTEGER</p>
                        <p>Формат данных – Число целое</p>
                        <p>Пример данных – 1000</p>
                    </div>
                </div>

                <x-slot:footer>
                    <x-button type="main" size="large">Вставить данные</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
