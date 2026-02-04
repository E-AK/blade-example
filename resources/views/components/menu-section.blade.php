<a
        href="{{ $href }}"
        class="
        menu-section
        d-flex align-items-center gap-2
        text-decoration-none text-reset
        {{ $active ? 'active' : '' }}
        {{ $hasChildren ? 'has-children' : '' }}
        {{ $class }}
    "
>
    @if ($icon)
        <span class="menu-icon d-flex align-items-center justify-content-center">
            {!! $icon !!}
        </span>
    @endif

    <span class="menu-text flex-grow-1">
        {{ $text }}
    </span>

    @if ($hasChildren)
        <span class="menu-arrow d-flex align-items-center">
            <i class="bi bi-arrow-right-short menu-arrow-icon"></i>
        </span>
    @endif
</a>
