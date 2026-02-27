@props([
    'items' => [],
    'actions' => false,
    'panelMatchTrigger' => false,
    'teleport' => false,
    'class' => '',
])

<div
    class="dropdown-root position-relative d-inline-block {{ $class }}"
    @if($panelMatchTrigger) data-panel-match-trigger="true" @endif
    data-teleport="{{ $teleport ? 'true' : 'false' }}"
    x-data="dropdown()"
    x-on:click.outside="{!! $teleport ? "(e) => !e.target.closest('.dropdown-panel') && close()" : 'close()' !!}"
    x-on:dropdown-close-others.window="$event.detail !== _dropdownId && close()"
    x-on:dropdown-close-self.window="$event.detail === _dropdownId && close()"
    x-bind:class="{ 'dropdown-root--open': open }"
>
    <div
        x-ref="trigger"
        class="dropdown-trigger"
        aria-haspopup="menu"
        x-bind:aria-expanded="open"
        @click.stop="toggle($event)"
    >
        {{ $trigger ?? '' }}
    </div>

    @if($teleport)
    <template x-teleport="body">
    @endif
    <div
        x-ref="panel"
        x-show="open"
        x-bind:style="panelStyle"
        x-bind:data-dropdown-id="_dropdownId"
        class="dropdown-panel"
        role="menu"
        x-cloak
    >
        <div class="dropdown-panel__inner">
            @if(!empty($items))
                @foreach($items as $item)
                    @if(!empty($item['separator']))
                        <x-dropdown.separator />
                    @else
                        @php
                            $state = $item['state'] ?? 'default';
                            $icon = $item['icon'] ?? 'none';
                            $isDisabled = $state === 'disabled';
                            $tag = !empty($item['url']) ? 'a' : 'button';
                            $href = $item['url'] ?? null;
                        @endphp
                        <{{ $tag }}
                            @if($tag === 'a') href="{{ $href }}" @else type="button" @endif
                            class="dropdown-item dropdown-item--{{ $icon }} dropdown-item--{{ $state }} {{ $actions ? 'dropdown-item--actions' : '' }}"
                            role="menuitem"
                            @disabled($isDisabled)
                            @if($isDisabled) aria-disabled="true" @endif
                            @foreach($item['extraAttributes'] ?? [] as $attrKey => $attrValue)
                                {!! $attrKey !!}="{{ $attrValue }}"
                            @endforeach
                        >
                            @if(in_array($icon, ['left', 'both', 'controllers'], true))
                                @if($icon === 'controllers')
                                    <x-checkbox
                                        :checked="$item['checked'] ?? false"
                                        :disabled="$isDisabled"
                                        size="20"
                                        class="dropdown-item__control"
                                    />
                                @elseif(!empty($item['iconName']))
                                    <span class="dropdown-item__icon dropdown-item__icon--left">
                                        <x-icon :name="$item['iconName']" :size="20" />
                                    </span>
                                @else
                                    <span class="dropdown-item__icon dropdown-item__icon--left dropdown-item__icon--placeholder" aria-hidden="true"></span>
                                @endif
                            @endif

                            @if($icon === 'label')
                                <div class="dropdown-item__content dropdown-item__content--label">
                                    @if(!empty($item['sublabel']))
                                        <span class="dropdown-item__sublabel">{{ $item['sublabel'] }}</span>
                                    @endif
                                    <span class="dropdown-item__label">{{ $item['label'] ?? '' }}</span>
                                </div>
                            @else
                                <span class="dropdown-item__label">{{ $item['label'] ?? '' }}</span>
                            @endif

                            @if(in_array($icon, ['right', 'both'], true))
                                <span class="dropdown-item__icon dropdown-item__icon--right">
                                    <x-icon name="arrow_right" :size="20" />
                                </span>
                            @endif
                        </{{ $tag }}>
                    @endif
                @endforeach
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
    @if($teleport)
    </template>
    @endif
</div>
