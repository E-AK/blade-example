@props([
    'text' => '',
    'bubbleVariant' => null,
])

<div
    {{ $attributes->merge(['class' => 'tooltip-wrapper d-inline-flex']) }}
    x-data="tooltip()"
    @mouseenter="open = true; $nextTick(() => $nextTick(() => updatePosition()))"
    @mouseleave="open = false"
>
    <div x-ref="trigger" class="tooltip-trigger d-flex align-items-center justify-content-center">
        {{ $slot }}
    </div>
    <template x-teleport="body">
        <div
            x-ref="bubble"
            class="tooltip-bubble tooltip-bubble--fixed {{ $bubbleVariant ? 'tooltip-bubble--' . $bubbleVariant : '' }}"
            x-show="open"
            :style="bubbleStyle"
            x-cloak
        >
            {{ $text }}
        </div>
    </template>
</div>
