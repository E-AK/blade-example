@extends('layouts.app')

@php
    $placeholderUsers = $placeholderUsers ?? [];
@endphp

@section('topbar_buttons')
    <x-button type="main" size="large">Создать новый аккаунт</x-button>
@endsection

@section('content')
    <div
        class="account-settings-page"
        x-data="{ accountSidebarOpen: false, selectedAccountId: null, showSendAccessForm: false }"
        @click="const tr = $event.target.closest('.data-table tbody tr'); if (tr) { selectedAccountId = tr.id; accountSidebarOpen = true; showSendAccessForm = false; }"
    >
        <x-table search-class="account-search" search-placeholder="Найти аккаунт" :data-table="$dataTable">
            <x-slot:filterSlot>
                <div style="width: 220px">
                    <x-select
                        text="Все статусы"
                        value=""
                        type="stroke"
                        placeholder="Все статусы"
                        :options="[
                            '' => 'Все статусы',
                            'true' => 'Активные',
                            'false' => 'Неактивные'
                        ]"
                    />
                </div>
            </x-slot:filterSlot>
        </x-table>
    </div>
@endsection
