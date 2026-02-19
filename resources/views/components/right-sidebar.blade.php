@php
    $dialogId = $titleId ?? 'right-sidebar-title-'.uniqid('', true);
    $closeButtonAttrs = array_merge(
        $closeButtonAttributes,
        ['x-on:click' => "\$dispatch('right-sidebar-close'); ".($closeButtonAttributes['x-on:click'] ?? $closeButtonAttributes['@click'] ?? '')]
    );
@endphp

@if($open)
    <div class="align-items-center">
        <div
                class="right-sidebar-overlay"
                role="dialog"
                aria-modal="true"
                aria-labelledby="{{ $title ? $dialogId : '' }}"
        @foreach($overlayAttributes as $key => $value) {!! $key !!}="{{ is_bool($value) ? ($value ? 'true' : 'false') : e($value) }}" @endforeach
        >
        <div class="right-sidebar">
            <header class="right-sidebar__header">
                @if($title !== null && $title !== '')
                    <h2 id="{{ $dialogId }}" class="right-sidebar__title">{{ $title }}</h2>
                @endif
                <x-button
                        type="stroke"
                        size="medium"
                        icon-position="only"
                        aria-label="{{ __('Close') }}"
                        class="right-sidebar__close"
                        :extra-attributes="$closeButtonAttrs"
                >
                    <x-slot:icon>
                        <x-icon name="arrow_close" :size="20" />
                    </x-slot:icon>
                </x-button>
            </header>

            <div class="right-sidebar__body">
                {{ $slot }}
            </div>

            @if(isset($footer) && $footer->isNotEmpty())
                <footer class="right-sidebar__footer">
                    {{ $footer }}
                </footer>
            @endif
        </div>
    </div>
@endif
