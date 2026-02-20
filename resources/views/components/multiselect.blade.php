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
    $wrapperClass = 'input-wrapper multiselect-wrapper';
    $wrapperClass .= ' input-wrapper--main';
    $wrapperClass .= ' ' . $class;

    $triggerClass = 'input-body input-body--main multiselect-trigger';
    $triggerClass .= ' ' . $class;

    if ($disabled) {
        $triggerClass .= ' disabled';
        if (!empty($selected)) {
            $triggerClass .= ' disabled-filled';
        }
    }

    if ($error) {
        $wrapperClass .= ' has-error';
        $triggerClass .= ' error';
    }

    if ($state === 'selected') {
        $wrapperClass .= ' state-selected';
    }

    if ($state === 'hover') {
        $triggerClass .= ' hover';
    }

    if (count($selected) >= 2) {
        $triggerClass .= ' multiselect--filled';
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

<div class="d-flex flex-column {{ $error ? 'gap-1' : 'gap-0' }}">
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
            class="{{ $triggerClass }}"
            role="combobox"
            :aria-expanded="open"
            aria-haspopup="listbox"
            @click="openDropdown()"
        >
            @if($leftIcon)
                <span class="input-icon multiselect-icon-left" aria-hidden="true">
                    <x-icon :name="$leftIcon" />
                </span>
            @endif

            <div class="input-content multiselect-content flex-grow-1 d-flex align-items-center min-w-0">
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
                    class="input-field multiselect-search"
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
                <span class="input-icons-right multiselect-icon-right">
                    <span class="input-icon"><x-icon name="arrow_chevron_down" /></span>
                </span>
            @endif
            @if(isset($right) && $right->isNotEmpty())
                <span class="multiselect-custom-right flex-shrink-0 d-flex align-items-center">
                    {{ $right }}
                </span>
            @endif
        </div>

        @if(!empty($options))
            <div
                class="dropdown-panel multiselect-dropdown"
                :class="{ 'multiselect-dropdown--hidden': !open }"
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click.stop
                x-cloak
            >
                <div class="dropdown-panel__inner">
                    @foreach($options as $val => $lab)
                        @php
                            $optionLabel = is_array($lab) ? ($lab['label'] ?? $val) : $lab;
                        @endphp
                        <div
                            class="dropdown-item multiselect-item"
                            :class="{ 'dropdown-item--selected': isSelected('{{ (string) $val }}') }"
                            role="option"
                            data-value="{{ $val }}"
                            data-label="{{ $optionLabel }}"
                            :aria-selected="isSelected('{{ (string) $val }}') ? 'true' : 'false'"
                            data-multiselect-option
                            @click="toggleOption($event.currentTarget)"
                        >
                            <span class="dropdown-item__label">{{ $optionLabel }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($name)
            <input type="hidden" name="{{ $name }}" value="{{ implode(',', $selected) }}" class="multiselect-input" :disabled="$disabled">
        @endif
    </div>
    @if($error)
        <span class="input-error multiselect-error">{{ $error }}</span>
    @endif
</div>
