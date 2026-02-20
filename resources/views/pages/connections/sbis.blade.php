@extends('layouts.app')

@section('topbar_buttons')
    <x-button type="string" size="large" icon-position="left">
        <x-slot:icon>
            <x-icon name="document_book" :size="20" />
        </x-slot:icon>
        Информация
    </x-button>
    <x-button type="main" size="large">Добавить аккаунт Сбис</x-button>
@endsection

@section('content')

@endsection
