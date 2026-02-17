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
                        <x-button type="main" size="medium">Продолжить</x-button>
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
            <x-button type="main" size="medium" class="toast-demo" data-state="success" data-message="Операция выполнена успешно.">Success (текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="success" data-message="Изменения сохранены." data-title="Успех">Success (заголовок + текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="error" data-message="Произошла ошибка. Попробуйте ещё раз.">Error (текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="error" data-message="Не удалось подключиться к серверу." data-title="Ошибка">Error (заголовок + текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="attention" data-message="Проверьте данные перед отправкой.">Attention (текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="attention" data-message="Сессия скоро истечёт." data-title="Внимание">Attention (заголовок + текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="info" data-message="Пароль перемещен в раздел Удаленные пароли">Info (текст)</x-button>
            <x-button type="main" size="medium" class="toast-demo" data-state="info" data-message="Обновление будет установлено при следующем входе." data-title="Информация">Info (заголовок + текст)</x-button>
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
            <div class="control-demo-panel border-2 border-dashed rounded p-4" style="border-color: #9747FF !important; width: 276px;">
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
            <div class="control-demo-panel border-2 border-dashed rounded p-4" style="border-color: #9747FF !important; width: 276px;">
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
            <div class="control-demo-panel border-2 border-dashed rounded p-4" style="border-color: #7B61FF !important; width: 351px;">
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

    {{-- ================= STEPPER ================= --}}
    <div class="mb-5">
        <h2 class="h2 mb-4">Stepper</h2>

        <div class="d-flex flex-column gap-5">
            <div>
                <h3 class="h6 text-muted mb-2">3 items (active first)</h3>
                <x-stepper>
                    <x-stepper-item :step-number="1" step-label="Шаг 1" title="Заголовок" state="active" />
                    <x-stepper-item :step-number="2" step-label="Шаг 2" title="Заголовок" />
                    <x-stepper-item :step-number="3" step-label="Шаг 3" title="Заголовок" :is-last="true" />
                </x-stepper>
            </div>

            <div>
                <h3 class="h6 text-muted mb-2">4 items (success, active, default)</h3>
                <x-stepper>
                    <x-stepper-item :step-number="1" step-label="Шаг 1" title="Заголовок" state="success" />
                    <x-stepper-item :step-number="2" step-label="Шаг 2" title="Заголовок" state="active" />
                    <x-stepper-item :step-number="3" step-label="Шаг 3" title="Заголовок" />
                    <x-stepper-item :step-number="4" step-label="Шаг 4" title="Заголовок" :is-last="true" />
                </x-stepper>
            </div>

            <div>
                <h3 class="h6 text-muted mb-2">All states (success, active, error, default)</h3>
                <x-stepper>
                    <x-stepper-item :step-number="1" step-label="Шаг 1" title="Заголовок" state="success" />
                    <x-stepper-item :step-number="2" step-label="Шаг 2" title="Заголовок" state="active" />
                    <x-stepper-item :step-number="3" step-label="Шаг 3" title="Заголовок" state="error" />
                    <x-stepper-item :step-number="4" step-label="Шаг 4" title="Заголовок" :is-last="true" />
                </x-stepper>
            </div>
        </div>
    </div>

    {{-- ================= MODAL (Alpine.js) ================= --}}
    <div class="mb-5" x-data="{
        modalSmall: false,
        modalSmallFooter: false,
        modalLarge: false,
        modalLargeFooter: false,
        modalWithIcon: false,
        modalFooterVariants: false,
        modalCustomSize: false
    }">
        <h2 class="h2 mb-4">Modal</h2>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-button type="main" size="medium" @click="modalSmall = true">Small, без кнопок в подвале</x-button>
            <x-button type="main" size="medium" @click="modalSmallFooter = true">Small, с кнопками (Подтвердить / Отмена)</x-button>
            <x-button type="main" size="medium" @click="modalLarge = true">Large, без кнопок</x-button>
            <x-button type="main" size="medium" @click="modalLargeFooter = true">Large, с кнопками</x-button>
            <x-button type="main" size="medium" @click="modalWithIcon = true">С иконкой у заголовка</x-button>
            <x-button type="main" size="medium" @click="modalFooterVariants = true">Разные кнопки в подвале</x-button>
            <x-button type="main" size="medium" @click="modalCustomSize = true">Нестандартный размер (800×520)</x-button>
        </div>

        {{-- Small, no footer — visibility controlled by Alpine x-show --}}
        <div x-show="modalSmall" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Заголовок"
                size="small"
                :close-button-attributes="['x-on:click' => 'modalSmall = false']"
                :overlay-attributes="['x-on:click.self' => 'modalSmall = false']"
            >
                Контент модального окна. Только заголовок и крестик — без кнопок в подвале.
            </x-modal>
        </div>

        {{-- Small, with footer --}}
        <div x-show="modalSmallFooter" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Подтверждение"
                size="small"
                :close-button-attributes="['x-on:click' => 'modalSmallFooter = false']"
                :overlay-attributes="['x-on:click.self' => 'modalSmallFooter = false']"
            >
                Вы уверены, что хотите выполнить это действие?
                <x-slot:footer>
                    <div class="d-flex gap-2">
                        <x-button type="secondary" size="medium" @click="modalSmallFooter = false">Отмена</x-button>
                        <x-button type="main" size="medium" @click="modalSmallFooter = false">Подтвердить</x-button>
                    </div>
                </x-slot:footer>
            </x-modal>
        </div>

        {{-- Large, no footer --}}
        <div x-show="modalLarge" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Заголовок (large)"
                size="large"
                :close-button-attributes="['x-on:click' => 'modalLarge = false']"
                :overlay-attributes="['x-on:click.self' => 'modalLarge = false']"
            >
                Большое модальное окно без кнопок в подвале. Размер 780×420.
            </x-modal>
        </div>

        {{-- Large, with footer --}}
        <div x-show="modalLargeFooter" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Подтверждение (large)"
                size="large"
                :close-button-attributes="['x-on:click' => 'modalLargeFooter = false']"
                :overlay-attributes="['x-on:click.self' => 'modalLargeFooter = false']"
            >
                Большое окно с кнопками в подвале.
                <x-slot:footer>
                    <div class="d-flex gap-2">
                        <x-button type="secondary" size="medium" @click="modalLargeFooter = false">Отмена</x-button>
                        <x-button type="main" size="medium" @click="modalLargeFooter = false">Подтвердить</x-button>
                    </div>
                </x-slot:footer>
            </x-modal>
        </div>

        {{-- With icon next to title --}}
        <div x-show="modalWithIcon" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Уведомление"
                size="small"
                :close-button-attributes="['x-on:click' => 'modalWithIcon = false']"
                :overlay-attributes="['x-on:click.self' => 'modalWithIcon = false']"
            >
                <x-slot:titleIcon>
                    <x-icon name="actions_mail" :size="20" />
                </x-slot:titleIcon>
                Сообщение с иконкой рядом с заголовком.
                <x-slot:footer>
                    <x-button type="main" size="medium" @click="modalWithIcon = false">Понятно</x-button>
                </x-slot:footer>
            </x-modal>
        </div>

        {{-- Footer with different button types --}}
        <div x-show="modalFooterVariants" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Удаление"
                size="small"
                class="modal--footer-between"
                :close-button-attributes="['x-on:click' => 'modalFooterVariants = false']"
                :overlay-attributes="['x-on:click.self' => 'modalFooterVariants = false']"
            >
                Удалить выбранный элемент? Это действие нельзя отменить.
                <x-slot:footer>
                    <div class="d-flex gap-2 justify-content-between flex-grow-1">
                        <div class="d-flex gap-2">
                            <x-button type="danger" size="medium" @click="modalFooterVariants = false">Удалить</x-button>
                        </div>
                        <x-button type="string" size="medium" @click="modalFooterVariants = false">Отмена</x-button>
                    </div>
                </x-slot:footer>
            </x-modal>
        </div>

        {{-- Custom size --}}
        <div x-show="modalCustomSize" x-cloak style="display: none;">
            <x-modal
                :open="true"
                title="Нестандартный размер"
                width="800px"
                :min-height="'520px'"
                :close-button-attributes="['x-on:click' => 'modalCustomSize = false']"
                :overlay-attributes="['x-on:click.self' => 'modalCustomSize = false']"
            >
                В некоторых кейсах размеры модального окна могут отличаться от стандартных (например, 800×520).
                <x-slot:footer>
                    <x-button type="main" size="medium" @click="modalCustomSize = false">Закрыть</x-button>
                </x-slot:footer>
            </x-modal>
        </div>
    </div>
@endsection
