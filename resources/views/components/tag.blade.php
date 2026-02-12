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
    'rightIcon' => 'close',
])

<div
        {{ $attributes->merge(['class' => $classes()]) }}
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
        <span class="tag-icon tag-icon-right">
            <x-icon
                    :name="$rightIconName()"
                    :size="$iconSize()"
                    color="currentColor"
                    stroke-width="{{ $size === 'sm' ? 1.28 : 1.6 }}"
            />
        </span>
    @endif
</div>