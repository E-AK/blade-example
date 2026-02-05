@extends('layouts.app')

@php
    $title = 'Аккаунты';
    $titleUrl = route('settings.account');

    $createLabel = 'Создать новый аккаунт';
@endphp

@section('content')
    <x-table :data-table="$dataTable">
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
