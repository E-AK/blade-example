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
        :extra-attributes="['onclick' => 'window.dispatchEvent(new CustomEvent(\'link-shortener-open-add-sidebar\'))']"
    >
        Добавить ссылку
    </x-button>
@endsection

@section('content')
    <div
        class="link-shortener-page"
        x-data="{ addLinkSidebarOpen: false, showComment: false }"
        @link-shortener-open-add-sidebar.window="addLinkSidebarOpen = true"
    >
        <x-table
            search-class="link-shortener-search"
            search-placeholder="Поиск"
            :data-table="$dataTable"
        />

        <template x-if="addLinkSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Новая ссылка"
                :close-button-attributes="['x-on:click' => 'addLinkSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'addLinkSidebarOpen = false']"
            >
                <x-input name="url" placeholder="Вставьте ссылку" />
                <x-button
                        type="string"
                        size="large"
                        icon-position="left"
                        @click="showComment = true"
                        x-show="!showComment"
                        class="justify-content-start"
                >
                    <x-slot:icon>
                        <x-icon name="validation_add_circle" :size="20" />
                    </x-slot:icon>
                    Добавить комментарий
                </x-button>
                <div x-show.important="showComment" x-cloak>
                    <x-input name="comment" placeholder="Комментарий" />
                </div>

                <x-slot:footer>
                    <x-button type="main" size="large">Сократить ссылку</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
