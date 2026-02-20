@extends('layouts.app')

@php
    $summaryButtonText = 'Создать новый аккаунт';
    $headerTitleText = 'Аккаунты';
    $placeholderUsers = $placeholderUsers ?? [];
@endphp

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
                        size="lg"
                        type="stroke"
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
