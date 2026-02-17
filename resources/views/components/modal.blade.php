@php
    $dialogId = $titleId ?? 'modal-title-'.uniqid('', true);
    $sizeClass = $size === 'large' ? 'modal--large' : 'modal--small';
    $style = [];
    if (!empty($width)) {
        $style[] = '--modal-width: ' . $width;
    }
    if (!empty($minHeight)) {
        $style[] = '--modal-min-height: ' . $minHeight;
    }
    $styleStr = implode('; ', $style);
    $parentClick = $closeButtonAttributes['x-on:click'] ?? $closeButtonAttributes['@click'] ?? '';
    $closeButtonAttrs = array_merge(
        $closeButtonAttributes,
        ['x-on:click' => "\$dispatch('modal-close'); " . $parentClick]
    );
@endphp

@if($open)
    <div
        class="modal-overlay {{ $sizeClass }} {{ $attributes->get('class') }}"
        role="dialog"
        aria-modal="true"
        aria-labelledby="{{ $title ? $dialogId : '' }}"
        @foreach($overlayAttributes as $key => $value) {!! $key !!}="{{ is_bool($value) ? ($value ? 'true' : 'false') : e($value) }}" @endforeach
        {{ $attributes->except('class') }}
    >
        <div
            class="modal"
            @style('height: auto')
            @if($styleStr) style="{{ $styleStr }}" @endif
        >
            <header class="modal__header">
                <div class="modal__header-inner">
                    @if(isset($titleIcon) && $titleIcon->isNotEmpty())
                        <span class="modal__title-icon" aria-hidden="true">
                            {{ $titleIcon }}
                        </span>
                    @endif
                    @if($title !== null && $title !== '')
                        <h2 id="{{ $dialogId }}" class="modal__title">{{ $title }}</h2>
                    @endif
                </div>
                <x-button
                    type="stroke"
                    size="medium"
                    icon-position="only"
                    aria-label="{{ __('Close') }}"
                    class="modal__close"
                    :extra-attributes="$closeButtonAttrs"
                >
                    <x-slot:icon>
                        <x-icon name="arrow_close" :size="20" />
                    </x-slot:icon>
                </x-button>
            </header>

            <div class="modal__body">
                {{ $slot }}
            </div>

            @if(isset($footer) && $footer->isNotEmpty())
                <footer class="modal__footer">
                    {{ $footer }}
                </footer>
            @endif
        </div>
@endif
