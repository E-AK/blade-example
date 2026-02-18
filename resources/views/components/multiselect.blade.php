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

<div
    class="{{ $wrapperClass }}"
    @if($disabled) aria-disabled="true" @endif
    data-tag-bg="{{ $tagBg }}"
    data-tag-color="{{ $tagColor }}"
    data-tag-border-color="{{ $tagBorderColor }}"
    data-disabled="{{ $disabled ? '1' : '0' }}"
    x-data="multiselect()"
    x-on:click.outside="close()"
    x-on:multiselect-close-others.window="if ($event.detail !== _msId) close()"
    :class="{ 'open': open, 'state-selected': open }"
>
    <div
        class="{{ $selectClass }}"
        role="combobox"
        :aria-expanded="open"
        aria-haspopup="listbox"
        @click="openDropdown()"
    >
        @if($leftIcon)
            <span class="multiselect-icon-left">
                <x-icon :name="$leftIcon" />
            </span>
        @endif

        <div class="multiselect-content flex-grow-1 d-flex flex-wrap align-items-center gap-2 min-w-0">
            <template x-for="value in selected" :key="value">
                <span class="multiselect-tag" :data-value="value">
                    <div
                        class="tag tag--md tag--icon-right border-solid"
                        :class="{ 'tag--hoverable': !disabled, 'is-disabled': disabled }"
                        :style="tagStyle()"
                    >
                        <span class="tag-text" x-text="getLabel(value)"></span>
                        <span
                            class="tag-icon tag-icon-right"
                            data-multiselect-remove
                            x-show="!disabled"
                            @click.stop="removeTag(value)"
                        >
                            <x-icon name="arrow_close" />
                        </span>
                    </div>
                </span>
            </template>
            <input
                type="text"
                class="multiselect-search"
                placeholder="{{ $hasSelection ? $searchPlaceholder : $placeholder }}"
                autocomplete="off"
                aria-label="{{ $searchPlaceholder }}"
                data-placeholder="{{ $placeholder }}"
                data-search-placeholder="{{ $searchPlaceholder }}"
                x-model="searchQuery"
                @input="filterDropdown()"
                @click.stop="openDropdown()"
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
        <x-dropdown :options="$options" :selected="$selected" :for-multiselect="true" />
    @endif

    @if($name)
        <input type="hidden" name="{{ $name }}" value="{{ implode(',', $selected) }}" class="multiselect-input" :disabled="$disabled">
    @endif
</div>
