@php
    $headerTitleText = 'Гостевые аккаунты';
    $headerInfoText = 'Настройки';
@endphp

@extends('layouts.app')

@section('topbar_buttons')
    <x-button
        type="main"
        size="large"
        :extra-attributes="['data-dispatch' => 'guestAccountsOpenSidebar']"
    >
        Добавить гостевой аккаунт
    </x-button>
@endsection

@section('content')
    <div
        class="guest-accounts-page"
        x-data="{
            guestAccountSidebarOpen: false,
            formName: '',
            formEmail: '',
            formPassword: '',
            formComment: '',
            get canCreate() {
                return this.formName.trim() !== '' && this.formEmail.trim() !== '';
            }
        }"
        @@guestAccountsOpenSidebar.window="guestAccountSidebarOpen = true"
    >
        <x-table
            search-class="guest-accounts-search"
            search-placeholder="Поиск"
            search-width="400px"
            :data-table="$dataTable"
        />

        <template x-if="guestAccountSidebarOpen">
            <x-right-sidebar
                :open="true"
                title="Создать гостевой аккаунт"
                :close-button-attributes="['x-on:click' => 'guestAccountSidebarOpen = false']"
                :overlay-attributes="['x-on:click.self' => 'guestAccountSidebarOpen = false']"
            >
                <form
                    id="guest-account-form"
                    action="{{ route('settings.guest-accounts.store') }}"
                    method="POST"
                    class="d-flex flex-column gap-3"
                >
                    @csrf
                    <div class="d-flex flex-column gap-2">
                        <label for="guest-account-name" class="fw-semibold text-body">Имя</label>
                        <x-input
                            id="guest-account-name"
                            type="main"
                            name="name"
                            placeholder="Имя"
                            x-model="formName"
                        />
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <label for="guest-account-email" class="fw-semibold text-body">Email</label>
                        <x-input
                            id="guest-account-email"
                            type="main"
                            name="email"
                            input-type="email"
                            placeholder="Email"
                            x-model="formEmail"
                        />
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <label for="guest-account-password" class="fw-semibold text-body">Пароль</label>
                        <x-input
                            id="guest-account-password"
                            type="main"
                            name="password"
                            input-type="password"
                            placeholder="Пароль"
                            x-model="formPassword"
                        />
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <label for="guest-account-comment" class="fw-semibold text-body">Комментарий</label>
                        <x-input
                            id="guest-account-comment"
                            type="main"
                            name="comment"
                            placeholder="Комментарий"
                            x-model="formComment"
                        />
                    </div>
                </form>
                <x-slot:footer>
                    <x-button
                        type="main"
                        size="large"
                        :extra-attributes="[
                            'type' => 'submit',
                            'form' => 'guest-account-form',
                            ':disabled' => '!canCreate',
                        ]"
                    >
                        Создать
                    </x-button>
                </x-slot:footer>
            </x-right-sidebar>
        </template>
    </div>
@endsection
