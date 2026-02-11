@extends('layouts.app')

@php
    $summaryButtonText = 'Создать новый аккаунт';
    $headerInfoText = 'Аккаунты';
    $headerTitleText = 'Аккаунты';
@endphp

@section('content')
    <x-table search-placeholder="Найти аккаунт" :data-table="$dataTable">
        <x-slot:filterSlot>
            <select class="data-table-filter form-select"
                    data-column="active"
                    aria-label="Filter by active status"
            >
                <option value="">Все статусы</option>
                <option value="true">Активные</option>
                <option value="false">Неактивные</option>
            </select>
        </x-slot:filterSlot>
    </x-table>
@endsection
