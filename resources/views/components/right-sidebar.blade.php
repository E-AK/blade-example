@php
    $dialogId = $titleId ?? 'right-sidebar-title-'.uniqid('', true);
    $closeButtonAttrs = array_merge(
        $closeButtonAttributes,
        ['x-on:click' => "\$dispatch('right-sidebar-close'); ".($closeButtonAttributes['x-on:click'] ?? $closeButtonAttributes['@click'] ?? '')]
    );
@endphp

@if($open)
    <div
            class="right-sidebar-overlay d-flex justify-content-end"
            role="dialog"
            aria-modal="true"
            aria-labelledby="{{ $title ? $dialogId : '' }}"
    @foreach(collect($overlayAttributes)->filter(fn ($_, $key) => $key !== '' && $key !== null) as $key => $value)
        {!! $key !!}="{{ is_bool($value) ? ($value ? 'true' : 'false') : e($value) }}"
    @endforeach
    >
    <div class="right-sidebar d-flex flex-column">
        <header class="right-sidebar__header d-flex align-items-center gap-3">
            @if(($title !== null && $title !== '') || (isset($titleSlot) && $titleSlot->isNotEmpty()))
                <h2 id="{{ $dialogId }}"
                    class="right-sidebar__title">{{ isset($titleSlot) && $titleSlot->isNotEmpty() ? $titleSlot : $title }}</h2>
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
                    <x-icon name="arrow_close" :size="20"/>
                </x-slot:icon>
            </x-button>
        </header>

        <div class="right-sidebar__body d-flex flex-column gap-3">
            {{ $slot }}
        </div>

        @if(isset($footer) && $footer->isNotEmpty())
            <footer class="right-sidebar__footer d-flex align-items-center gap-2">
                {{ $footer }}
            </footer>
        @endif
    </div>
    </div>
@endif
