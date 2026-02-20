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
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'sbis-open-add-sidebar\'))']"
    >
        Добавить аккаунт Сбис
    </x-button>
@endsection

@section('content')
    <div
            class="account-settings-page"
            x-data="{ sbisSidebarOpen: false }"
            @click="if ($event.target.closest('.table-sidebar-open-trigger')) { const tr = $event.target.closest('.data-table tbody tr'); if (tr) { sbisSidebarOpen = true; } }"
            @sbis-open-add-sidebar.window="sbisSidebarOpen = true"
    >
        <x-table
            search-class="sbis-search"
            search-placeholder="Поиск подключений"
            :data-table="$dataTable"
        />

        <template x-if="sbisSidebarOpen">
            <x-right-sidebar
                    :open="true"
                    title="Добавление нового аккаунта Сбис"
                    :close-button-attributes="['x-on:click' => 'sbisSidebarOpen = false']"
                    :overlay-attributes="['x-on:click.self' => 'sbisSidebarOpen = false']"
            >
                <x-input name="id" placeholder="id приложения" />
                <x-input name="protected_key" placeholder="Защищенный ключ" />
                <x-input name="service_key" placeholder="Сервисный ключ" inputType="password" leftIcon="document_folder" />
                <x-input name="comment" placeholder="Комментарий" />

                <x-slot:footer>
                    <x-button type="main">Сохранить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
