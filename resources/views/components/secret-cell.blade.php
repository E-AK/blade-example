@props([
    'value' => '',
    'columnName' => 'Ключ',
    'warningTooltip' => null,
    'alertTooltip' => null,
])

<div
    class="sbis-secret-cell"
    data-real-value="{{ e((string) $value) }}"
    data-column-name="{{ e($columnName) }}"
    x-data="{ masked: true, realValue: '', columnName: '' }"
    x-init="realValue = $el.getAttribute('data-real-value') || ''; columnName = $el.getAttribute('data-column-name') || 'Ключ'"
>
    <span class="sbis-secret-cell__text sbis-secret-cell__text--revealed" x-show="masked" x-text="'********'"></span>
    <span class="sbis-secret-cell__text sbis-secret-cell__text--revealed" x-show="!masked" x-text="realValue"></span>
    <x-button
        type="string"
        size="small"
        icon-position="only"
        class="sbis-secret-cell__btn p-0 border-0"
        :extra-attributes="[
            'x-on:click' => 'navigator.clipboard.writeText(realValue); if (window.Toast) window.Toast.success(columnName + \' скопирован\')',
            'aria-label' => 'Копировать',
        ]"
    >
        <x-slot:icon>
            <x-icon name="document_copy" :size="20" />
        </x-slot:icon>
    </x-button>
    <x-button
        type="string"
        size="small"
        icon-position="only"
        class="sbis-secret-cell__btn p-0 border-0"
        aria-label="Показать или скрыть"
        :extra-attributes="[
            'x-on:click' => 'masked = !masked',
        ]"
    >
        <x-slot:icon>
            <span x-show.important="masked" class="d-inline-flex sbis-secret-cell__icon-wrap"><x-icon name="eye_alt" :size="20" /></span>
            <span x-show.important="!masked" class="d-inline-flex sbis-secret-cell__icon-wrap"><x-icon name="actions_eye_hide" :size="20" /></span>
        </x-slot:icon>
    </x-button>
    @if($warningTooltip)
        <x-tooltip :text="$warningTooltip" bubbleVariant="pill" class="sbis-secret-cell__icon-tooltip">
            <span class="sbis-secret-cell__icon-wrap sbis-secret-cell__icon-wrap--warning d-inline-flex align-items-center justify-content-center" aria-hidden="true">
                <x-icon name="validation_warning" :size="20" />
            </span>
        </x-tooltip>
    @endif
    @if($alertTooltip)
        <x-tooltip :text="$alertTooltip" bubbleVariant="pill" class="sbis-secret-cell__icon-tooltip">
            <span class="sbis-secret-cell__icon-wrap sbis-secret-cell__icon-wrap--alert d-inline-flex align-items-center justify-content-center" aria-hidden="true">
                <x-icon name="validation_alert" :size="20" />
            </span>
        </x-tooltip>
    @endif
</div>
