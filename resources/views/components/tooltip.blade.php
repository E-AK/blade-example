<div
    class="tooltip-wrapper d-inline-flex"
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
            class="tooltip-bubble tooltip-bubble--fixed"
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            :style="bubbleStyle"
            x-cloak
        >
            {{ $text }}
        </div>
    </template>
</div>
