@props([
    'items' => [],
])

@if($forSelect && !empty($options))
    <ul class="input-dropdown select-dropdown list-unstyled m-0" role="listbox">
        @foreach($options as $val => $lab)
            @php
                $label = is_array($lab) ? ($lab['label'] ?? $val) : $lab;
            @endphp
            <li class="input-dropdown-item select-item" data-value="{{ $val }}">{{ $label }}</li>
        @endforeach
    </ul>
@elseif($forMultiselect && !empty($options))
    <div
        class="multiselect-dropdown custom-dropdown border rounded shadow-sm"
        @click.stop
    >
        <ul class="multiselect-dropdown-list list-unstyled m-0" role="listbox">
            @foreach($options as $val => $lab)
                @php
                    $label = is_array($lab) ? ($lab['label'] ?? $val) : $lab;
                    $valEnc = json_encode((string) $val);
                    $alpineClass = "{ 'multiselect-item--selected': isSelected({$valEnc}) }";
                    $alpineAria = "isSelected({$valEnc}) ? 'true' : 'false'";
                @endphp
                <li
                    class="dropdown-item multiselect-item"
                    :class="{!! $alpineClass !!}"
                    role="option"
                    data-value="{{ $val }}"
                    data-label="{{ $label }}"
                    :aria-selected="{!! $alpineAria !!}"
                    data-multiselect-option
                    @click="toggleOption($event.currentTarget)"
                >
                    <div class="item-label">{{ $label }}</div>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div
        class="dropdown-menu custom-dropdown {{ $forActionCell ? 'dropdown-menu--action-cell' : '' }}"
        id="{{ $id }}"
        {{ $attributes }}
    >
        @foreach($items as $item)
            @if(!empty($item['separator']))
                <div class="dropdown-menu__separator" role="separator"></div>
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
                    @disabled($isDisabled)
                    @if($isDisabled) aria-disabled="true" @endif
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
                            <span class="dropdown-item__label">{{ $item['label'] }}</span>
                        </div>
                    @else
                        <span class="dropdown-item__label">{{ $item['label'] }}</span>
                    @endif

                    @if(in_array($icon, ['right', 'both'], true))
                        <span class="dropdown-item__icon dropdown-item__icon--right" aria-hidden="true">
                            <x-icon name="arrow_right" :size="20" />
                        </span>
                    @endif
                </{{ $tag }}>
            @endif
        @endforeach
    </div>
@endif
