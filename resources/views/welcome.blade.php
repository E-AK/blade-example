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
                />

                <x-multiselect
                        :options="$options"
                        :selected="[1,2]"
                        disabled
                        leftIcon="actions_profile"
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

    {{-- ================= CHECKBOX, RADIO, SWITCH ================= --}}
    <div class="mb-5">
        <h2 class="h2 mb-4">Checkbox, Radio, Switch</h2>

        <div class="d-flex flex-wrap gap-5">
            {{-- Checkbox --}}
            <div class="control-demo-panel border border-2 border-dashed rounded p-4" style="border-color: #9747FF !important; width: 276px;">
                <h3 class="h6 mb-3">Checkbox</h3>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb1" size="16" class="control-demo-hover" />
                        <span class="text-muted small">Default 16, hover</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb2" size="16" />
                        <span class="text-muted small">Default 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb3" size="16" disabled />
                        <span class="text-muted small">Disabled 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb4" size="16" error="Error" />
                        <span class="text-muted small">Error 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb5" size="16" checked disabled />
                        <span class="text-muted small">Disabled selected 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb6" size="16" checked />
                        <span class="text-muted small">Selected 16</span>
                    </div>
                </div>
                <div class="d-flex flex-column gap-3 mt-3 pt-3 border-top">
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb7" size="20" />
                        <span class="text-muted small">Default 20</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-checkbox name="cb8" size="20" checked />
                        <span class="text-muted small">Selected 20</span>
                    </div>
                </div>
            </div>

            {{-- Radio --}}
            <div class="control-demo-panel border border-2 border-dashed rounded p-4" style="border-color: #9747FF !important; width: 276px;">
                <h3 class="h6 mb-3">Radio</h3>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r1" value="a" size="16" class="control-demo-hover" />
                        <span class="text-muted small">Default 16, hover</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r1" value="b" size="16" />
                        <span class="text-muted small">Default 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r2" value="a" size="16" disabled />
                        <span class="text-muted small">Disabled 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r3" value="a" size="16" error="Error" />
                        <span class="text-muted small">Error 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r4" value="a" size="16" checked disabled />
                        <span class="text-muted small">Disabled selected 16</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r5" value="a" size="16" checked />
                        <span class="text-muted small">Selected 16</span>
                    </div>
                </div>
                <div class="d-flex flex-column gap-3 mt-3 pt-3 border-top">
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r6" value="a" size="20" />
                        <span class="text-muted small">Default 20</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-radio name="r6" value="b" size="20" checked />
                        <span class="text-muted small">Selected 20</span>
                    </div>
                </div>
            </div>

            {{-- Switch --}}
            <div class="control-demo-panel border border-2 border-dashed rounded p-4" style="border-color: #7B61FF !important; width: 351px;">
                <h3 class="h6 mb-3">Switch</h3>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw1" size="large" />
                        <span class="text-muted small">Large, default</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw2" size="large" showText />
                        <span class="text-muted small">Large, ON/OFF</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw3" size="large" loading />
                        <span class="text-muted small">Large, loading</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw4" size="large" disabled />
                        <span class="text-muted small">Large, disabled</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw5" size="large" checked />
                        <span class="text-muted small">Large, selected</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw6" size="large" checked showText />
                        <span class="text-muted small">Large, selected ON/OFF</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw7" size="large" checked loading />
                        <span class="text-muted small">Large, selected loading</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw8" size="large" checked disabled />
                        <span class="text-muted small">Large, selected disabled</span>
                    </div>
                </div>
                <div class="d-flex flex-column gap-3 mt-3 pt-3 border-top">
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw9" size="small" />
                        <span class="text-muted small">Small, default</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw10" size="small" showText />
                        <span class="text-muted small">Small, ON/OFF</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <x-switch name="sw11" size="small" checked />
                        <span class="text-muted small">Small, selected</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= BUTTON TOGGLE ================= --}}
    <div class="mb-5">
        <h2 class="h2 mb-4">Button toggle</h2>

        <div class="d-flex flex-column gap-5">
            <div>
                <h3 class="h6 text-muted mb-2">2 items (text)</h3>
                <x-button-toggle>
                    <x-button-toggle-item name="bt1" value="active" label="Активные" selected="active" />
                    <x-button-toggle-item name="bt1" value="all" label="Все" selected="active" />
                </x-button-toggle>
            </div>

            <div>
                <h3 class="h6 text-muted mb-2">3 items (text)</h3>
                <x-button-toggle>
                    <x-button-toggle-item name="bt2" value="a" label="Опция A" selected="b" />
                    <x-button-toggle-item name="bt2" value="b" label="Опция B" selected="b" />
                    <x-button-toggle-item name="bt2" value="c" label="Опция C" selected="b" />
                </x-button-toggle>
            </div>

            <div>
                <h3 class="h6 text-muted mb-2">State + text + badge</h3>
                <x-button-toggle>
                    <x-button-toggle-item name="bt3" value="active" label="Активные" type="state" variant="success" selected="active" />
                    <x-button-toggle-item name="bt3" value="all" label="Все" :badge="4" selected="active" />
                    <x-button-toggle-item name="bt3" value="pay" label="Оплата" type="icon" icon="specific_payment" selected="active" />
                </x-button-toggle>
            </div>

            <div>
                <h3 class="h6 text-muted mb-2">Size small</h3>
                <x-button-toggle>
                    <x-button-toggle-item name="bt4" value="a" label="Малый A" size="small" selected="a" />
                    <x-button-toggle-item name="bt4" value="b" label="Малый B" size="small" selected="a" />
                    <x-button-toggle-item name="bt4" value="c" label="Малый C" size="small" selected="a" />
                </x-button-toggle>
            </div>

            <div>
                <h3 class="h6 text-muted mb-2">С отключённым пунктом</h3>
                <x-button-toggle>
                    <x-button-toggle-item name="bt5" value="on" label="Вкл" selected="on" />
                    <x-button-toggle-item name="bt5" value="off" label="Выкл" selected="on" />
                    <x-button-toggle-item name="bt5" value="lock" label="Заблокировано" disabled selected="on" />
                </x-button-toggle>
            </div>
        </div>
    </div>
@endsection
