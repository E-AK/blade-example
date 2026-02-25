@php
    $headerTitleText = 'Настройка импорта данных';
@endphp

@extends('layouts.app')

@section('topbar_buttons')
    <div class="d-flex align-items-center gap-2">
        <x-select
            type="stroke"
            placeholder="ИП Васильев Петр Ильич"
            :options="[ 1 => 'ООО Сбис-Вятка',
                2 => 'ООО Нутриотика',
                3 => 'ИП Васильев Петр Ильич',
                4 => 'ООО Рога и копыта',
                5 => 'ИП Сидоров А. А.',
            ]"
            class="import-settings-select"
            :pilled="true"
        />
        <x-button
            type="main"
            size="large"
            :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'import-settings-open-add-sidebar\'))']"
        >
            Добавить задание
        </x-button>
    </div>
@endsection

@section('content')
    <div
        class="import-settings-page"
        x-data="{ addTaskSidebarOpen: false }"
        @import-settings-open-add-sidebar.window="addTaskSidebarOpen = true"
    >
        <x-table
            search-class="import-settings-search"
            search-placeholder="Поиск"
            :data-table="$dataTable"
        />

        <template x-if="addTaskSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Добавить задание"
                :close-button-attributes="['x-on:click' => 'addTaskSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'addTaskSidebarOpen = false']"
            >
                <x-select
                        name="1"
                        placeholder="Выберите раздел"
                        :options="[1 => 1]"
                />
                <x-select
                        name="2"
                        placeholder="Новые пароли 2024"
                        :options="[1 => 1]"
                />
                <div class="d-flex flex-row" style="gap: 12px">
                    <x-switch
                            name="send_webhook"
                    />
                    <label for="send_webhook" class="p3">Отправлять вебхуки</label>
                </div>
                <x-slot:footer>
                    <x-button type="main" size="large">Сохранить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
