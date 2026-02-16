@props([
    'name' => null,
    'checked' => false,
    'disabled' => false,
    'loading' => false,
    'size' => 'large',
    'showText' => false,
    'class' => '',
])

@php
    $size = $size === 'small' ? 'small' : 'large';
    $inputId = 'switch-'.($name ? preg_replace('/[^a-z0-9]+/i', '-', $name).'-' : '').uniqid('', true);
@endphp

<label
        class="control-switch {{ $class }}"
        for="{{ $inputId }}"
        data-size="{{ $size }}"
        data-show-text="{{ $showText ? 'true' : 'false' }}"
        @if($disabled) data-disabled="true" @endif
        @if($loading) data-loading="true" @endif
        @if($checked) data-selected="true" @endif
>
    <input
            type="checkbox"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="1"
            class="control-switch__input"
            role="switch"
            aria-checked="{{ $checked ? 'true' : 'false' }}"
            @checked($checked)
            @disabled($disabled)
    @if($name && $attributes->has('wire:model'))
        {{ $attributes->only('wire:model') }}
            @endif
    >
    <span class="control-switch__track" aria-hidden="true">
        @if($showText)
            <span class="control-switch__content control-switch__content--on">
                <span class="control-switch__text control-switch__text--on">ON</span>
                <span class="control-switch__spacer"></span>
            </span>
        @endif
        <span class="control-switch__knob">
            <span class="control-switch__knob-inner"></span>
            @if($loading)
                {{-- TODO: correct loading --}}
                <span class="control-switch__loading" aria-hidden="true">
                    <x-icon name="switch_nob_loading" />
                </span>
            @endif
        </span>
        @if($showText)
            <span class="control-switch__content control-switch__content--off">
                <span class="control-switch__spacer"></span>
                <span class="control-switch__text control-switch__text--off">OFF</span>
            </span>
        @endif
    </span>
</label>
