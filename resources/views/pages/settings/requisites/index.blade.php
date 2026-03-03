@php
    $headerTitleText = 'Реквизиты';
    $headerInfoText = 'Настройки';
@endphp

@extends('layouts.app')

@section('content')
    <div class="requisites-page">
        <form
                id="requisites-form"
                action="{{ route('settings.requisites.store') }}"
                method="POST"
                class="d-flex flex-column gap-4"
        >
            @csrf

            @if (session('success'))
                <div class="alert alert-success mb-0" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex flex-column gap-3">
                <span class="requisites-label fw-semibold text-body">Тип контрагента</span>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <x-radio
                                name="counterparty_type"
                                value="legal"
                                :checked="old('counterparty_type', 'legal') === 'legal'"
                                label="Юридическое лицо"
                        />
                    </div>
                    <div class="d-flex flex-row align-items-center gap-2">
                        <x-radio
                                name="counterparty_type"
                                value="individual"
                                :checked="old('counterparty_type') === 'individual'"
                                label="ИП"
                        />
                    </div>
                </div>
            </div>

            <div class="requisites-fields d-flex flex-column">
                <x-input
                        type="main"
                        name="name"
                        placeholder="Наименование организации"
                        :value="old('name')"
                        :error="$errors->first('name')"
                />
                <x-input
                        type="main"
                        name="inn"
                        placeholder="ИНН"
                        :value="old('inn')"
                        :error="$errors->first('inn')"
                />
                <x-input
                        type="main"
                        name="kpp"
                        placeholder="КПП"
                        :value="old('kpp')"
                        :error="$errors->first('kpp')"
                />
                <x-input
                        type="main"
                        name="address"
                        placeholder="Юридический адрес"
                        :value="old('address')"
                        :error="$errors->first('address')"
                />
            </div>

            <div class="requisites-submit">
                <x-button
                        type="main"
                        size="large"
                        :extra-attributes="[
                                'type' => 'submit',
                                'form' => 'requisites-form',
                            ]"
                >
                    Сохранить
                </x-button>
            </div>
        </form>
    </div>
@endsection
