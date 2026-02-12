@extends('layouts.app')

@php
    $summaryButtonText = 'Создать новый аккаунт';
    $headerInfoText = 'Аккаунты';
    $headerTitleText = 'Аккаунты';
@endphp

@section('content')
    <x-table search-placeholder="Найти аккаунт" :data-table="$dataTable">
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
            />
        </x-slot:filterSlot>
    </x-table>
@endsection
