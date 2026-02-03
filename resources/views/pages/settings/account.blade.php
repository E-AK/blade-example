@extends('layouts.app')

@php
    $title = 'Аккаунты';
    $titleUrl = route('settings.account');

    $createLabel = 'Создать новый аккаунт';
@endphp

@section('content')
    {{ $dataTable->table() }}
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush