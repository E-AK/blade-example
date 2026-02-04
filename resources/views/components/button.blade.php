<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes()]) }}
>
    @if ($loading)
        <span class="spinner-border spinner-border-sm me-2"></span>
    @endif

    @if ($iconLeft)
        {!! $iconLeft !!}
    @endif

    <span>{{ $slot }}</span>

    @if ($iconRight)
        {!! $iconRight !!}
    @endif
</button>
