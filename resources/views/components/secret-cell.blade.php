@props([
    'value' => '',
    'columnName' => 'Ключ',
])

@php
    $safeValue = e($value);
@endphp
<div
    class="sbis-secret-cell"
    x-data="{ masked: true, realValue: '{{ $safeValue }}', columnName: '{{ e($columnName) }}' }"
>
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
    @php
        $ariaLabelToggle = "masked ? 'Показать' : 'Скрыть'";
    @endphp
    <x-button
        type="string"
        size="small"
        icon-position="only"
        class="sbis-secret-cell__btn p-0 border-0"
        :extra-attributes="[
            'x-on:click' => 'masked = !masked',
            ':aria-label' => $ariaLabelToggle,
        ]"
    >
        <x-slot:icon>
            <span x-show.important="masked" class="d-inline-flex sbis-secret-cell__icon-wrap"><x-icon name="eye_alt" :size="20" /></span>
            <span x-show.important="!masked" class="d-inline-flex sbis-secret-cell__icon-wrap"><x-icon name="actions_eye_hide" :size="20" /></span>
        </x-slot:icon>
    </x-button>
    <span class="sbis-secret-cell__text sbis-secret-cell__text--revealed" x-show="masked" x-text="'********'"></span>
    <span class="sbis-secret-cell__text sbis-secret-cell__text--revealed" x-show="!masked" x-text="realValue"></span>
</div>
