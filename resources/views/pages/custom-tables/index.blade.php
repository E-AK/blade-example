@php
    $headerTitleText = 'Пользовательские таблицы';
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
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'custom-tables-open-create\'))']"
    >
        Создать новую таблицу
    </x-button>
@endsection

@section('content')
    <div
        class="custom-tables-page"
        x-data="{
            createSidebarOpen: false,
            deleteModalOpen: false,
            tableToDelete: null
        }"
        @custom-table-delete.window="tableToDelete = $event.detail; deleteModalOpen = true"
        @click="if ($event.target.closest('.table-sidebar-open-trigger')) {
            const tr = $event.target.closest('.data-table tbody tr');
            if (tr && tr.dataset.viewUrl) {
                window.location = tr.dataset.viewUrl;
            }
        }"
        @custom-tables-open-create.window="createSidebarOpen = true"
    >
        <x-table
            search-class="custom-tables-search"
            search-placeholder="Поиск по названию таблицы"
            :data-table="$dataTable"
            :has-sidebar="true"
            sidebar-label="Просмотр"
        />

        <template x-if="createSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Создание новой таблицы"
                :close-button-attributes="['x-on:click' => 'createSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'createSidebarOpen = false']"
            >
                <div class="d-flex flex-column" style="gap: 12px">
                    <div class="d-flex flex-column gap-1">
                        <h4>Введите название новой таблицы</h4>
                        <p class="p4">К наименованию  таблицы будет добавлен префикс формата "usertable_"</p>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <x-input name="name" placeholder="Название таблицы" />
                    </div>
                    <div class="p4 text-grey-1" style="font-size: 14px !important;">Не больше 32 символов</div>
                </div>
                <x-slot:footer>
                    <x-button type="main" size="large">Создать</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>

        <template x-if="deleteModalOpen">
            <x-modal
                :open="true"
                title="Удалить таблицу"
                :close-button-attributes="['x-on:click' => 'deleteModalOpen = false; tableToDelete = null']"
                :overlay-attributes="['x-on:click.self' => 'deleteModalOpen = false; tableToDelete = null']"
            >
                <p class="mb-0" x-text="tableToDelete ? 'Вы собираетесь удалить таблицу «' + tableToDelete.name + '», в которой находится ' + tableToDelete.row_count + ' строк.' : ''"></p>
                <x-slot:footer>
                    <div class="d-flex gap-2 justify-content-end">
                        <x-button
                            type="stroke"
                            size="large"
                            :extra-attributes="['x-on:click' => 'deleteModalOpen = false; tableToDelete = null']"
                        >
                            Назад
                        </x-button>
                        <x-button type="danger" size="large">
                            Удалить
                        </x-button>
                    </div>
                </x-slot:footer>
            </x-modal>
        </template>
    </div>
@endsection
