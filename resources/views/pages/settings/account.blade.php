@extends('layouts.app')

@php
    $summaryButtonText = 'Создать новый аккаунт';
    $headerTitleText = 'Управление аккаунтами';
    $placeholderUsers = $placeholderUsers ?? [];
@endphp

@section('content')
    <div
            class="account-settings-page"
            x-data="{ accountSidebarOpen: false, selectedAccountId: null, showSendAccessForm: false }"
            @click="if ($event.target.closest('.table-sidebar-open-trigger')) { const tr = $event.target.closest('.data-table tbody tr'); if (tr) { selectedAccountId = tr.id; accountSidebarOpen = true; showSendAccessForm = false; } }"
    >
        <x-table search-class="account-search" search-placeholder="Найти аккаунт" :data-table="$dataTable" :has-sidebar="true" />

        <template x-if="accountSidebarOpen">
            <x-right-sidebar
                    :open="true"
                    title="Детали аккаунта"
                    :close-button-attributes="['x-on:click' => 'accountSidebarOpen = false']"
                    :overlay-attributes="['x-on:click.self' => 'accountSidebarOpen = false']"
            >
                <div class="account-sidebar-body d-flex flex-column align-items-stretch w-100">
                    {{-- User cards (same component as profile modal) --}}
                    <div class="d-flex flex-column" @style('gap: 12px')>
                        @foreach($placeholderUsers as $user)
                            <div class="account-sidebar-card">
                                <x-user-card
                                        :name="$user['name']"
                                        :email="$user['email'] ?? ''"
                                        :role="$user['role'] ?? 'Менеджер'"
                                        wrapper-class="account-sidebar-card-inner"
                                />
                            </div>
                        @endforeach

                        <div class="pt-2" x-show="!showSendAccessForm">
                            <x-button
                                    type="string"
                                    size="medium"
                                    icon-position="left"
                                    :extra-attributes="['x-on:click' => 'showSendAccessForm = true']"
                            >
                                <x-slot:icon>
                                    <x-icon name="actions_mail" :size="20" />
                                </x-slot:icon>
                                Отправить доступ к аккаунту
                            </x-button>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-stretch gap-3" x-show.important="showSendAccessForm">
                        <div class="d-flex flex-column gap-2">
                            <span class="fw-semibold text-body account-sidebar-label">Email</span>
                            <span class="text-secondary account-sidebar-hint">Укажите email для отправки доступа</span>
                        </div>

                        <x-multiselect
                                name="invite_emails"
                                placeholder="Email"
                                search-placeholder="Добавить email"
                                :options="[]"
                                :selected="['irina-lvova@yandex.ru']"
                                :allow-custom="true"
                                class="w-100 account-sidebar-multiselect-inner"
                        >
                            <x-slot:right>
                                <x-tooltip
                                        text="Доступ будет отправлен после нажатия кнопки «Отправить»"
                                        placement="top"
                                >
                                            <span class="d-flex align-items-center justify-content-center text-secondary" aria-hidden="true">
                                                <x-icon name="validation_info" :size="20" />
                                            </span>
                                </x-tooltip>
                            </x-slot:right>
                        </x-multiselect>

                        <div class="d-flex flex-row gap-2 align-items-start">
                            <x-button
                                    type="main"
                                    size="medium"
                                    class="account-sidebar-btn-send"
                                    :extra-attributes="['title' => 'Доступ будет отправлен после нажатия кнопки «Отправить»']"
                            >
                                Отправить
                            </x-button>
                            <x-button
                                    type="stroke"
                                    size="medium"
                                    :extra-attributes="['x-on:click' => 'showSendAccessForm = false']"
                            >
                                Отмена
                            </x-button>
                        </div>
                    </div>
                </div>

                <x-slot:footer>
                    <x-button type="main">Сохранить</x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
