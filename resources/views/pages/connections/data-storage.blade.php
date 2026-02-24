@php
    $headerTitleText = 'Хранение данных'
@endphp

@extends('layouts.app')

@section('topbar_buttons')
    <x-button type="string" size="large" icon-position="left">
        <x-slot:icon>
            <x-icon name="document_book" :size="20" />
        </x-slot:icon>
        Информация
    </x-button>
    <x-button
        type="main"
        size="large"
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'data-storage-open-add-sidebar\'))']"
    >
        Добавить удаленное подключение
    </x-button>
@endsection

@section('content')
    <div
        class="data-storage-page"
        x-data="{ addSidebarOpen: false }"
        @click="if ($event.target.closest('.table-sidebar-open-trigger')) { const tr = $event.target.closest('.data-table tbody tr'); if (tr) { addSidebarOpen = true; } }"
        @data-storage-open-add-sidebar.window="addSidebarOpen = true"
    >
        <x-table
            search-class="data-storage-search"
            search-placeholder="Поиск по адресу, базе или пользователю"
            :data-table="$dataTable"
        />

        <template x-if="addSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Добавить удаленное подключение"
                :close-button-attributes="['x-on:click' => 'addSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'addSidebarOpen = false']"
            >
                <div
                    class="d-flex flex-column gap-3"
                    x-data="{ accessType: 'any' }"
                    @change="accessType = $event.target.value"
                >
                    <h4>Тип доступа</h4>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="data_storage_access_type" value="any" size="20" checked>
                            <span class="text-muted small">Доступ с любого IP адреса</span>
                        </x-radio>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="data_storage_access_type" value="specified" size="20">
                            <span class="text-muted small">Доступ с указанного IP адреса</span>
                        </x-radio>
                    </div>

                    <template x-if="accessType === 'specified'">
                        <div>
                            <x-input name="ip_access" placeholder="IP Адрес" />
                        </div>
                    </template>

                    <x-input name="comment" placeholder="Комментарий" />
                </div>

                <x-slot:footer>
                    <x-button type="main" size="large">Создать</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
