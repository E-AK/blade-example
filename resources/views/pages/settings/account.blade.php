@extends('layouts.app')

@php
    $summaryButtonText = 'Создать новый аккаунт';
    $headerInfoText = 'Аккаунты';
    $headerTitleText = 'Аккаунты';
@endphp

@section('content')
    <x-table search-class="account-search" search-placeholder="Найти аккаунт" :data-table="$dataTable">
        <x-slot:filterSlot>
            <x-select
                    text="Все статусы"
                    size="lg"
                    type="stroke"
                    :options="[
                    '' => 'Все статусы',
                    'true' => 'Активные',
                    'false' => 'Неактивные'
                ]"
                    class="select-account"
            />
        </x-slot:filterSlot>
    </x-table>
@endsection
