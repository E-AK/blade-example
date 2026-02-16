@props([
    'name' => null,
    'placeholder' => 'Сотрудники',
    'searchPlaceholder' => 'Поиск...',
    'leftIcon' => null,
    'options' => [],
    'selected' => [],
    'disabled' => false,
    'error' => null,
    'state' => null,
    'showRightIcon' => false,
    'tagBg' => 'grey-4',
    'tagColor' => 'black',
    'tagBorderColor' => 'grey-4',
    'class' => '',
])

@php
    $wrapperClass = 'multiselect-wrapper';
    $selectClass = 'multiselect flex align-items-center';
    $selectClass .= ' '.$class;

    if ($disabled) {
        $selectClass .= ' disabled';
        if (!empty($selected)) {
            $selectClass .= ' disabled-filled';
        }
    }

    if ($error) {
        $wrapperClass .= ' has-error';
        $selectClass .= ' error';
    }

    if ($state === 'selected') {
        $wrapperClass .= ' state-selected';
    }

    if ($state === 'hover') {
        $selectClass .= ' hover';
    }

    if (count($selected) >= 2) {
        $selectClass .= ' multiselect--filled';
    }

    $selectedOptions = collect($selected)->map(function ($value) use ($options) {
        $opt = $options[$value] ?? null;
        if (is_array($opt)) {
            return [
                'value' => (string) $value,
                'label' => $opt['label'] ?? (string) $value,
                'tag' => $opt['tag'] ?? null,
            ];
        }

        return ['value' => (string) $value, 'label' => $opt ?? (string) $value];
    })->values()->all();

    $hasSelection = !empty($selectedOptions);
@endphp

<div class="{{ $wrapperClass }}" @if($disabled) aria-disabled="true" @endif>
    <div class="{{ $selectClass }}" role="combobox" aria-expanded="false" aria-haspopup="listbox">
        @if($leftIcon)
            <span class="multiselect-icon-left">
                <x-icon :name="$leftIcon" />
            </span>
        @endif

        <div class="multiselect-content flex-grow-1 d-flex flex-wrap align-items-center gap-2 min-w-0">
            @foreach($selectedOptions as $option)
                @php
                    $optionTagBg = is_array($option['tag'] ?? null) ? ($option['tag']['bg'] ?? $tagBg) : $tagBg;
                    $optionTagColor = is_array($option['tag'] ?? null) ? ($option['tag']['color'] ?? $tagColor) : $tagColor;
                    $optionTagBorderColor = is_array($option['tag'] ?? null) ? ($option['tag']['borderColor'] ?? $tagBorderColor) : $tagBorderColor;
                @endphp
                <span class="multiselect-tag" data-value="{{ $option['value'] }}">
                    <x-tag
                        :text="$option['label']"
                        icon="{{ $disabled ? 'none' : 'right' }}"
                        rightIcon="arrow_close"
                        :bg="$optionTagBg"
                        :color="$optionTagColor"
                        :borderColor="$optionTagBorderColor"
                        :hoverable="!$disabled"
                    />
                </span>
            @endforeach

            <input
                type="text"
                class="multiselect-search"
                placeholder="{{ $hasSelection ? $searchPlaceholder : $placeholder }}"
                autocomplete="off"
                aria-label="{{ $searchPlaceholder }}"
                data-placeholder="{{ $placeholder }}"
                data-search-placeholder="{{ $searchPlaceholder }}"
                @if($disabled) disabled @endif
            />
        </div>

        @if($showRightIcon)
            <span class="multiselect-icon-right">
                <x-icon name="arrow_chevron_down" />
            </span>
        @endif
    </div>

    @if($error)
        <span class="multiselect-error">{{ $error }}</span>
    @endif

    @if(!empty($options))
        <div class="multiselect-dropdown border rounded shadow-sm">
            <ul class="multiselect-dropdown-list list-unstyled m-0" role="listbox">
                @foreach($options as $val => $lab)
                    @php
                        $label = is_array($lab) ? ($lab['label'] ?? $val) : $lab;
                    @endphp
                    <li class="multiselect-item" role="option" data-value="{{ $val }}" data-label="{{ $label }}" aria-selected="{{ in_array((string) $val, array_map('strval', $selected)) ? 'true' : 'false' }}">
                        {{ $label }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($name)
        <input type="hidden" name="{{ $name }}" value="{{ implode(',', $selected) }}" class="multiselect-input" :disabled="$disabled">
    @endif

    {{-- Template for JS-created tags (clone this for new selections) --}}
    <template class="multiselect-tag-template">
        <span class="multiselect-tag" data-value="">
            <x-tag
                text=""
                icon="right"
                rightIcon="arrow_close"
                :bg="$tagBg"
                :color="$tagColor"
                :borderColor="$tagBorderColor"
                hoverable="false"
            />
        </span>
    </template>
</div>
