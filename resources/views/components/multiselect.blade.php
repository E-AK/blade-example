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
    'allowCustom' => false,
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

<div @if($error) class="d-flex flex-column gap-1" @endif>
    <div
            class="{{ $wrapperClass }}"
            @if($disabled) aria-disabled="true" @endif
            data-tag-bg="{{ $tagBg }}"
            data-tag-color="{{ $tagColor }}"
            data-tag-border-color="{{ $tagBorderColor }}"
            data-disabled="{{ $disabled ? '1' : '0' }}"
            data-allow-custom="{{ $allowCustom ? '1' : '0' }}"
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

            <div class="multiselect-content flex-grow-1 d-flex align-items-center min-w-0">
                <div
                    class="multiselect-tags-absolute"
                    x-ref="tagsWrap"
                    x-show="selected.length > 0"
                >
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
                </div>
                <span
                    class="multiselect-tags-spacer"
                    :style="{ width: tagsSpacerWidth + 'px' }"
                    aria-hidden="true"
                ></span>
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
                        @keydown.enter.prevent="addCustomIfAllowed()"
                        @click.stop="openDropdown()"
                        @if($disabled) disabled @endif
                />
            </div>

            @if($showRightIcon)
                <span class="multiselect-icon-right">
                <x-icon name="arrow_chevron_down" />
            </span>
            @endif
            @if(isset($right) && $right->isNotEmpty())
                <span class="multiselect-custom-right flex-shrink-0 d-flex align-items-center">
                    {{ $right }}
                </span>
            @endif
        </div>

        @if(!empty($options))
            <x-dropdown :options="$options" :selected="$selected" :for-multiselect="true" />
        @endif

        @if($name)
            <input type="hidden" name="{{ $name }}" value="{{ implode(',', $selected) }}" class="multiselect-input" :disabled="$disabled">
        @endif
    </div>
    @if($error)
        <span class="multiselect-error">{{ $error }}</span>
    @endif
</div>