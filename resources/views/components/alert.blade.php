<div {{ $attributes->merge(['class' => $classes()]) }}>
    <div class="alert__inner">
        <span class="alert__icon">
            <x-icon :name="$iconName()" :size="20" />
        </span>

        <div class="alert__content">
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
