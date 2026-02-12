<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes()]) }}
>
    @if ($loading)
        <span class="spinner-border spinner-border-sm me-2"></span>
    @endif

    @if ($iconLeft)
        <x-icon :name="$iconLeft"/>
    @endif

    @if($text)
        <span>{{ $text }}</span>
    @endif

    @if ($iconRight)
        <x-icon :name="$iconRight"/>
    @endif
</button>