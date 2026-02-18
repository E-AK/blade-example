@props([
    'items' => [],
])

@if($forMultiselect && !empty($options))
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
    <div class="custom-dropdown" id="{{ $id }}">
        @foreach($items as $item)
            <div class="dropdown-item
                {{ $item['state'] ?? 'default' }}
                {{ $item['icon'] ?? 'icon-none' }}">

                @if(isset($item['icon']) && in_array($item['icon'], ['left','both','controllers','label']))
                    <div class="icon-left"></div>
                @endif

                <div class="item-label">{{ $item['label'] }}</div>

                @if(isset($item['icon']) && in_array($item['icon'], ['right','both']))
                    <div class="icon-right"></div>
                @endif

                @if(isset($item['icon']) && in_array($item['icon'], ['controllers','label']))
                    <div class="icon-controller"></div>
                @endif
            </div>
        @endforeach
    </div>
@endif
