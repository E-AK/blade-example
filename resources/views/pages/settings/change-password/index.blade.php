@php
    $headerTitleText = 'Изменить пароль';
    $headerInfoText = 'Настройки';
@endphp

@extends('layouts.app')

@section('content')
    <div class="change-password-page">
        <form
            id="change-password-form"
            action="{{ route('settings.change-password.store') }}"
            method="POST"
            class="d-flex flex-column gap-4"
        >
            @csrf

            @if (session('success'))
                <div class="alert alert-success mb-0" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="change-password-fields d-flex flex-column">
                <x-input
                    type="main"
                    name="current_password"
                    input-type="password"
                    placeholder="Текущий пароль"
                    :error="$errors->first('current_password')"
                />
                <x-input
                    type="main"
                    name="password"
                    input-type="password"
                    placeholder="Новый пароль"
                    :error="$errors->first('password')"
                />
                <x-input
                    type="main"
                    name="password_confirmation"
                    input-type="password"
                    placeholder="Подтверждение пароля"
                    :error="$errors->first('password_confirmation')"
                />
            </div>

            <div class="change-password-submit">
                <x-button
                    type="main"
                    size="large"
                    :extra-attributes="[
                        'type' => 'submit',
                        'form' => 'change-password-form',
                    ]"
                >
                    Сохранить
                </x-button>
            </div>
        </form>
    </div>
@endsection
