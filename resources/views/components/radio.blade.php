@props([
    'name' => null,
    'value' => '',
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
    $inputId = 'radio-'.($name ? preg_replace('/[^a-z0-9]+/i', '-', $name).'-' : '').preg_replace('/[^a-z0-9]+/i', '-', (string) $value).'-'.uniqid();
@endphp

<label
    class="control-radio {{ $class }}"
    for="{{ $inputId }}"
    data-size="{{ $size }}"
    @if($hasError) data-state="error" @endif
    @if($disabled) data-state="{{ $isDisabledSelected ? 'disabled-selected' : 'disabled' }}" @endif
    @if($checked && !$disabled) data-state="selected" @endif
>
    <input
        type="radio"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        class="control-radio__input"
        @checked($checked)
        @disabled($disabled)
        @if($name && $attributes->has('wire:model')) {{ $attributes->only('wire:model') }} @endif
    >
    <span class="control-radio__circle" aria-hidden="true"></span>
    @if($label)
        <span class="control-radio__label">{{ $label }}</span>
    @endif
    {{ $slot ?? '' }}
</label>

@if($error && is_string($error))
    <span class="control-radio__error">{{ $error }}</span>
@endif
