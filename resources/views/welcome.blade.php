@extends('layouts.app')

@section('content')
    <h1 class="h1 mb-4">Компоненты</h1>

    {{-- ================= ALERT ================= --}}
    <div class="mb-5">
        <h2 class="h2 mb-4">Alert — все состояния</h2>
        <div class="d-flex flex-column gap-4">
            <div>
                <h3 class="h6 text-muted mb-2">Success (текст)</h3>
                <x-alert state="success">Операция выполнена успешно.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Success (заголовок + текст)</h3>
                <x-alert state="success" title="Успех">Изменения сохранены.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Error (текст)</h3>
                <x-alert state="error">Произошла ошибка. Попробуйте ещё раз.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Error (заголовок + текст)</h3>
                <x-alert state="error" title="Ошибка">Не удалось подключиться к серверу.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Attention (текст)</h3>
                <x-alert state="attention">Проверьте данные перед отправкой.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Attention (заголовок + текст)</h3>
                <x-alert state="attention" title="Внимание">Сессия скоро истечёт.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Attention (с кнопкой)</h3>
                <x-alert state="attention" title="Внимание">
                    Сессия скоро истечёт. Продолжить?
                    <x-slot:button>
                        <x-button text="Продолжить" variant="main" size="md" />
                    </x-slot:button>
                </x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Info (текст)</h3>
                <x-alert state="info">Новая версия приложения доступна.</x-alert>
            </div>
            <div>
                <h3 class="h6 text-muted mb-2">Info (заголовок + текст)</h3>
                <x-alert state="info" title="Информация">Обновление будет установлено при следующем входе.</x-alert>
            </div>
        </div>
    </div>

    {{-- ================= TOAST ================= --}}
    <div class="mb-5">
        <h2 class="h2 mb-4">Toast</h2>
        <p class="text-muted mb-3">Нажмите кнопку — toast появится внизу по центру (как в примере).</p>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary toast-demo" data-state="success" data-message="Операция выполнена успешно.">Success (текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="success" data-message="Изменения сохранены." data-title="Успех">Success (заголовок + текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="error" data-message="Произошла ошибка. Попробуйте ещё раз.">Error (текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="error" data-message="Не удалось подключиться к серверу." data-title="Ошибка">Error (заголовок + текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="attention" data-message="Проверьте данные перед отправкой.">Attention (текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="attention" data-message="Сессия скоро истечёт." data-title="Внимание">Attention (заголовок + текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="info" data-message="Пароль перемещен в раздел Удаленные пароли">Info (текст)</button>
            <button type="button" class="btn btn-primary toast-demo" data-state="info" data-message="Обновление будет установлено при следующем входе." data-title="Информация">Info (заголовок + текст)</button>
        </div>
    </div>

    {{-- ================= MULTISELECT ================= --}}
    <h2 class="h2 mb-4">Multiselect — все состояния</h2>
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
