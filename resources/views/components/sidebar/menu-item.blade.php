<div {{ $attributes }}>
    @if($asButton)
        <button
                type="button"
                class="d-flex align-items-center text-start w-100 border-0 text-decoration-none position-relative justify-content-between {{ $classes() }}"
        >
            @else
                <a
                        href="{{ $href }}"
                        class="d-flex align-items-center text-decoration-none text-reset position-relative justify-content-between {{ $classes() }}"
                >
                    @endif
                    <div class="item-container">
                        @if ($icon)
                            <span class="menu-icon d-flex align-items-center justify-content-center fs-5 lh-1">
                                <x-icon :name="$icon"/>
                            </span>
                        @endif

                        @if($text !== '')
                            <span class="menu-text flex-grow-1 d-block text-truncate">
                                {{ $text }}

                                @if($badgeCount !== null && $badgeCount !== '')
                                    <span class="menu-item__count">{{ $badgeCount }}</span>
                                @endif
                            </span>
                        @endif

                        @if($shortText !== '' && !$isSubmenu)
                            <span class="menu-short-text d-none d-app-collapsed d-flex justify-content-center align-items-center">
                                {{ $shortText }}
                            </span>
                        @endif
                    </div>
                    @if ($trailingIcon)
                        <span class="menu-icon menu-icon--trailing d-flex align-items-center justify-content-center flex-shrink-0">
                            <x-icon :name="$trailingIcon"/>
                        </span>
                    @endif
                    @if ($isNew)
                        <span class="menu-badge">new</span>
                    @endif

                    @if ($hasChildren)
                        <span class="menu-arrow d-flex align-items-center">
        <i class="bi bi-arrow-right-short menu-arrow-icon fs-4 lh-1"></i>
      </span>
            @endif

            @if($asButton)
        </button>
        @else
            </a>
    @endif
</div>
