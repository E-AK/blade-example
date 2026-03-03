<div {{ $attributes->merge(['class' => $classes() . ' d-flex align-items-center']) }}>
    <div class="alert__inner d-flex align-items-center gap-2 flex-grow-1 min-w-0">
        <span class="alert__icon">
            <x-icon :name="$iconName()" :size="20" />
        </span>

        <div class="alert__content d-flex align-items-center gap-2 flex-grow-1 min-w-0">
            @if ($hasTitle())
                <span class="alert__title">{{ $title }}</span>
            @endif
            <span class="alert__text">{{ $slot }}</span>
        </div>

        @if (isset($button) && $button->isNotEmpty())
            <div class="alert__action">
                {{ $button }}
            </div>
        @endif
    </div>
</div>
