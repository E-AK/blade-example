<a href="{{$paymentRoute}}" {{ $attributes->merge(['class' => $classes()]) }}>
    <div class="balance-container d-flex align-items-center">
        <div class="item-container">
            <span class="menu-icon balance-left-icon d-flex align-items-center justify-content-center">
                <x-icon name="menu_wallet"/>
            </span>

                <span class="flex-grow-1 text-truncate">
                Баланс<span class="sum">: {{ $balance }}</span>
            </span>
        </div>
    </div>

    <span class="menu-arrow balance-action-icon d-flex align-items-center justify-content-center">
            @if($variant === 'red')
            <x-icon name="validation_alert"/>
        @else
            <x-icon name="validation_add_circle"/>
        @endif
    </span>
</a>