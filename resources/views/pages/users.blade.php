@extends('layouts.app')

@section('topbar_buttons')
    <x-button type="main" size="large">Добавить нового пользователя</x-button>
@endsection

@section('content')
    <div class="users-settings-page">
        <x-table
            search-class="users-search"
            search-placeholder="Найти пользователя"
            :data-table="$dataTable"
        >
            <x-slot:filterSlot>
                <x-select
                    text="Все параметры"
                    size="lg"
                    type="stroke"
                    :options="['' => 'Все параметры']"
                />
            </x-slot:filterSlot>
        </x-table>
    </div>
@endsection
