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
