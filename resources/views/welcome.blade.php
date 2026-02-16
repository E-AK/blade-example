@extends('layouts.app')

@section('content')
    <h1 class="h1 mb-4">Multiselect — все состояния</h1>

    @php
        $options = [
            1 => 'Иван Иванов',
            2 => 'Петр Петров',
            3 => 'Виктория Полищук',
        ];
    @endphp

    <div class="d-flex flex-column gap-5">

        {{-- ================= HOVER ================= --}}
        <div>
            <h3>Hover</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        state="hover"
                        placeholder="Сотрудники"
                />

                <x-multiselect
                        :options="$options"
                        state="hover"
                        leftIcon="actions_profile"
                        placeholder="Сотрудники"
                />
            </div>
        </div>

        {{-- ================= SELECTED ================= --}}
        <div>
            <h3>Selected (1 значение)</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        :selected="[1]"
                        state="selected"
                        search-placeholder="Сотрудники"
                />

                <x-multiselect
                        :options="$options"
                        :selected="[1]"
                        state="selected"
                        leftIcon="actions_profile"
                        search-placeholder="Сотрудники"
                />
            </div>
        </div>

        {{-- ================= SEMI FILLED ================= --}}
        <div>
            <h3>Semi-filled (1 тег + placeholder)</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        :selected="[3]"
                        state="selected"
                        search-placeholder="Сотрудники"
                />

                <x-multiselect
                        :options="$options"
                        :selected="[3]"
                        state="selected"
                        leftIcon="actions_profile"
                        search-placeholder="Сотрудники"
                />
            </div>
        </div>

        {{-- ================= FILLED ================= --}}
        <div>
            <h3>Filled (2+ тегов)</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        :selected="[1,2]"
                        search-placeholder="Сотрудники"
                />

                <x-multiselect
                        :options="$options"
                        :selected="[1,2]"
                        leftIcon="actions_profile"
                        search-placeholder="Сотрудники"
                />
            </div>
        </div>

        {{-- ================= DISABLED DEFAULT ================= --}}
        <div>
            <h3>Disabled (empty)</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        disabled
                />

                <x-multiselect
                        :options="$options"
                        disabled
                        leftIcon="actions_profile"
                />
            </div>
        </div>

        {{-- ================= DISABLED FILLED ================= --}}
        <div>
            <h3>Disabled (filled)</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        :selected="[1,2]"
                        disabled
{{--                        search-placeholder="Сотрудники"--}}
                />

                <x-multiselect
                        :options="$options"
                        :selected="[1,2]"
                        disabled
                        leftIcon="actions_profile"
{{--                        search-placeholder="Сотрудники"--}}
                />
            </div>
        </div>

        {{-- ================= ERROR ================= --}}
        <div>
            <h3>Error</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        error="Поле обязательно для заполнения"
                />

                <x-multiselect
                        :options="$options"
                        error="Поле обязательно для заполнения"
                        leftIcon="actions_profile"
                />
            </div>
        </div>

        {{-- ================= WITH RIGHT ICON ================= --}}
        <div>
            <h3>Right icon (chevron)</h3>

            <div class="d-flex gap-4 flex-wrap">
                <x-multiselect
                        :options="$options"
                        showRightIcon
                />

                <x-multiselect
                        :options="$options"
                        :selected="[1]"
                        showRightIcon
                        search-placeholder="Сотрудники"
                />
            </div>
        </div>

    </div>
@endsection
