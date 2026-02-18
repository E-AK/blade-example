@props([
    'text' => '',
    'size' => 'md',
    'icon' => 'none',
    'selected' => false,
    'disabled' => false,
    'hoverable' => true,
    'bg' => 'white',
    'color' => 'black',
    'borderColor' => 'grey-4',
    'hoverBg' => 'green',
    'hoverColor' => 'white',
    'hoverBorderColor' => 'green',
    'borderStyle' => 'solid',
    'leftIcon' => 'specific_tag',
    'rightIcon' => 'arrow_close',
    'rightIconAttributes' => [],
])

@php
    $safeAttributes = $attributes->filter(fn ($value) => is_scalar($value) || $value === null);
@endphp
<div
        {{ $safeAttributes->merge(['class' => $classes()]) }}
        style="{{ $inlineStyles() }}"
>
    @if($hasLeftIcon())
        <span class="tag-icon tag-icon-left">
            <x-icon
                    :name="$leftIconName()"
                    :size="$iconSize()"
                    color="currentColor"
                    stroke-width="{{ $size === 'sm' ? 1.28 : 1.6 }}"
            />
        </span>
    @endif

    <span class="tag-text">{{ $text }}</span>

    @if($hasRightIcon())
        <span
            class="tag-icon tag-icon-right"
            @foreach(is_array($rightIconAttributes) ? $rightIconAttributes : [] as $attrKey => $attrVal)
                @if(is_scalar($attrVal))
                    {{ $attrKey }}="{{ e($attrVal) }}"
                @endif
            @endforeach
        >
            <x-icon
                    :name="$rightIconName()"
                    :size="$iconSize()"
                    color="currentColor"
                    stroke-width="{{ $size === 'sm' ? 1.28 : 1.6 }}"
            />
        </span>
    @endif
</div>