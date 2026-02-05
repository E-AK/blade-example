<div {{ $attributes }}>
    @if($asButton)
        <button
                type="button"
                class="{{ $classes() }} d-flex align-items-center gap-2 text-start w-100 border-0 bg-transparent"
        >
            @else
                <a
                        href="{{ $href }}"
                        class="{{ $classes() }} d-flex align-items-center gap-2 text-decoration-none text-reset"
                >
                    @endif

                    @if ($icon)
                        <span class="menu-icon d-flex align-items-center justify-content-center">
                {!! $icon !!}
            </span>
                    @endif

                    @if($text !== '')
                        <span class="menu-text flex-grow-1">
                {{ $text }}
            </span>
                    @endif

                    @if ($hasChildren)
                        <span class="menu-arrow d-flex align-items-center">
                <i class="bi bi-arrow-right-short menu-arrow-icon"></i>
            </span>
            @endif

            @if($asButton)
        </button>
        @else
            </a>
    @endif
</div>
