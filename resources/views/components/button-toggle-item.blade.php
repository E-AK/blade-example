@props([
    'name' => null,
    'value' => '',
    'label' => '',
    'selected' => null,
    'disabled' => false,
    'size' => 'large',
    'type' => 'text',
    'variant' => 'success',
    'icon' => null,
    'badge' => null,
    'class' => '',
])

@php
    $size = $size === 'small' ? 'small' : 'large';
    $type = in_array($type, ['text', 'state', 'icon'], true) ? $type : 'text';
    $isSelected = $selected !== null && (string) $selected === (string) $value;
    $inputId = 'button-toggle-'.($name ? preg_replace('/[^a-z0-9]+/i', '-', $name).'-' : '').preg_replace('/[^a-z0-9]+/i', '-', (string) $value).'-'.uniqid('', true);
@endphp

<label
    for="{{ $inputId }}"
    {{ $attributes->except('wire:model')->merge(['class' => 'button-toggle-item ' . $class]) }}
    data-size="{{ $size }}"
    data-type="{{ $type }}"
    @if($disabled) data-state="disabled" @endif
    @if($isSelected) data-state="selected" @endif
>
    <input
        type="radio"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        class="button-toggle-item__input"
        @checked($isSelected)
        @disabled($disabled)
        {{ $attributes->only('wire:model') }}
    >
    <span class="button-toggle-item__content">
        @if($type === 'state')
            <x-status :variant="$variant" :text="$label" />
        @else
            @if($type === 'icon' && $icon)
                <x-icon :name="$icon" class="button-toggle-item__icon" />
            @endif
            <span class="button-toggle-item__label">{{ $label }}</span>
        @endif
        @if($badge !== null && $badge !== '')
            <span class="button-toggle-item__badge">{{ $badge }}</span>
        @endif
    </span>
</label>
