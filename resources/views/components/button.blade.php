<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes()]) }}
>
    @if ($loading)
        <span class="spinner-border spinner-border-sm me-2"></span>
    @endif

    @if ($iconLeft)
        <i class="{{ $iconLeft }} me-1"></i>
    @endif

    <span>{{ $slot }}</span>

    @if ($iconRight)
        <i class="{{ $iconRight }} ms-1"></i>
    @endif
</button>
