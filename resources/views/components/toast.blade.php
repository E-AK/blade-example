<div {{ $attributes->merge(['class' => 'toast d-flex align-items-center ' . $classes(), 'role' => 'alert']) }} data-bs-autohide="true" data-bs-delay="5000">
    <div class="toast-custom__inner d-flex align-items-center gap-2 flex-grow-1 min-w-0">
        <span class="toast-custom__icon d-flex align-items-center justify-content-center flex-shrink-0" aria-hidden="true">
            <x-icon :name="$iconName()" :size="20" />
        </span>

        <div class="toast-custom__content d-flex align-items-center gap-2 flex-grow-1 min-w-0">
            @if ($hasTitle())
                <span class="toast-custom__title">{{ $title }}</span>
            @endif
            <span class="toast-custom__text">{{ $slot }}</span>
        </div>

        <button type="button" class="toast-custom__close btn-close-custom d-inline-flex align-items-center justify-content-center flex-shrink-0" aria-label="{{ __('Close') }}" data-bs-dismiss="toast">
            <x-icon name="arrow_close" :size="20" />
        </button>
    </div>
</div>
