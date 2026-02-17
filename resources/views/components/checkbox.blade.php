@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'error' => null,
    'size' => '16',
    'label' => null,
    'class' => '',
])

@php
    $size = in_array($size, ['16', '20'], true) ? $size : '16';
    $hasError = (bool) $error;
    $isDisabledSelected = $disabled && $checked;
    $inputId = 'checkbox-'.($name ? preg_replace('/[^a-z0-9]+/i', '-', $name).'-' : '').uniqid('', true);
@endphp

<label
        class="control-checkbox {{ $class }}"
        for="{{ $inputId }}"
        data-size="{{ $size }}"
        @if($hasError) data-state="error" @endif
        @if($disabled) data-state="{{ $isDisabledSelected ? 'disabled-selected' : 'disabled' }}" @endif
        @if($checked && !$disabled) data-state="selected" @endif
>
    <input
            type="checkbox"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            class="control-checkbox__input"
            @checked($checked)
            @disabled($disabled)
    @if($name && $attributes->has('wire:model'))
        {{ $attributes->only('wire:model') }}
            @endif
    >
    <span class="control-checkbox__box" aria-hidden="true">
        <span class="control-checkbox__check">
            <svg width="8" height="6" viewBox="0 0 8 6" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 3L3 5L7 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </span>
    </span>
    @if($label)
        <span class="control-checkbox__label">{{ $label }}</span>
    @endif
    {{ $slot ?? '' }}
</label>

@if($error && is_string($error))
    <span class="control-checkbox__error">{{ $error }}</span>
@endif
