<div {{ $attributes->merge(['class' => 'toast ' . $classes(), 'role' => 'alert']) }} data-bs-autohide="true" data-bs-delay="5000">
    <div class="toast-custom__inner">
        <span class="toast-custom__icon" aria-hidden="true">
            <x-icon :name="$iconName()" :size="20" />
        </span>

        <div class="toast-custom__content">
            @if ($hasTitle())
                <span class="toast-custom__title">{{ $title }}</span>
            @endif
            <span class="toast-custom__text">{{ $slot }}</span>
        </div>

        <button type="button" class="toast-custom__close btn-close-custom" aria-label="{{ __('Close') }}" data-bs-dismiss="toast">
            <x-icon name="arrow_close" :size="20" />
        </button>
    </div>
</div>
