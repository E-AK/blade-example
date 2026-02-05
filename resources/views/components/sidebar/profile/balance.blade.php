<div {{ $attributes->merge(['class' => $classes()]) }}>
    <div class="balance-container d-flex align-items-center gap-2 w-100">

        {{-- Левая иконка --}}
        <span class="menu-icon balance-left-icon d-flex align-items-center justify-content-center">
            <i class="bi bi-wallet2"></i>
        </span>

        {{-- Текст --}}
        <span class="b2 menu-text flex-grow-1 text-truncate">
            Баланс<span class="sum">: {{ $balance }}</span>
        </span>

        {{-- Правая иконка --}}
        <span class="menu-arrow balance-action-icon d-flex align-items-center justify-content-center">
            @if($variant === 'red')
                <i class="bi bi-exclamation-circle-fill"></i>
            @else
                <i class="bi bi-plus-circle-fill"></i>
            @endif
        </span>

    </div>
</div>