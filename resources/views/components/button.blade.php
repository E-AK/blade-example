@php
    $tag = $href !== null ? 'a' : 'button';
    $fullClass = trim($classList . ' ' . ($attributes->get('class') ?? ''));
    $mergedAttrs = $attributes->merge($extraAttributes ?? [])->merge(['class' => $fullClass]);
    if ($tag === 'button' && $href === null) {
        $mergedAttrs = $mergedAttrs->merge(['type' => $attributes->get('type', 'button')]);
    }
    if ($tag === 'button' && $disabled) {
        $mergedAttrs = $mergedAttrs->merge(['disabled' => true]);
    }
    if ($tag === 'a' && $href !== null) {
        $mergedAttrs = $mergedAttrs->merge(['href' => $href]);
    }
    if ($tag === 'a' && $disabled) {
        $mergedAttrs = $mergedAttrs->merge(['aria-disabled' => 'true']);
    }
@endphp

<{{ $tag }} {{ $mergedAttrs }}>
    <span class="btn__inner">
        @if($iconPosition === 'left' && isset($icon) && $icon->isNotEmpty())
            <span class="btn__icon btn__icon--left" aria-hidden="true">{{ $icon }}</span>
        @endif
        @if($iconPosition === 'only' && isset($icon) && $icon->isNotEmpty())
            <span class="btn__icon btn__icon--only" aria-hidden="true">{{ $icon }}</span>
        @endif
        @if($iconPosition !== 'only' && $slot->isNotEmpty())
            <span class="btn__label">{{ $slot }}</span>
        @endif
        @if($iconPosition === 'right' && isset($icon) && $icon->isNotEmpty())
            <span class="btn__icon btn__icon--right" aria-hidden="true">{{ $icon }}</span>
        @endif
    </span>
</{{ $tag }}>
