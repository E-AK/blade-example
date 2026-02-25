@php
    $headerTitleText = 'Редактирование таблицы';
@endphp

@extends('layouts.app')

@section('topbar_buttons')
    <x-button
        type="main"
        size="large"
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'custom-table-add-column-open\'))']"
    >
        Добавить колонку
    </x-button>
@endsection

@section('content')
    <div
        class="custom-tables-edit-page"
        x-data="{ addColumnSidebarOpen: false }"
        @custom-table-add-column-open.window="addColumnSidebarOpen = true"
    >
        <x-table
            search-class="custom-table-columns-search"
            search-placeholder=""
            :data-table="$dataTable"
            :show-search="false"
        />

        <template x-if="addColumnSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Добавление колонки"
                :close-button-attributes="['x-on:click' => 'addColumnSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'addColumnSidebarOpen = false']"
            >
                <x-input name="name" placeholder="Название колонки" />
                <x-select
                    name="data_type"
                    placeholder="Тип данных"
                    :options="[
                        'Строка' => 'Строка',
                        'Число целое' => 'Число целое',
                        'Число с запятой' => 'Число с запятой',
                        'Да/Нет' => 'Да/Нет',
                        'Дата' => 'Дата',
                    ]"
                />
                <x-select
                    name="is_required"
                    placeholder="Необходимость заполнения"
                    :options="[
                        0 => 'Не обязательное',
                        1 => 'Обязательное',
                    ]"
                />
                <x-select
                    name="add_after_column_id"
                    placeholder="Добавить после колонки"
                    :options="collect(['' => 'В начало'])->union($customTable->columns->mapWithKeys(fn ($c) => [$c->id => 'После «' . $c->name . '»']))->all()"
                />
                <x-input name="example_data" placeholder="Пример данных" />
                <x-input name="comment" placeholder="Комментарий" />
                <x-slot:footer>
                    <x-button type="main" size="large">Добавить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
