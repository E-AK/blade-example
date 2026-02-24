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

<div
    class="d-flex flex-column {{ $error ? 'gap-1' : 'gap-0' }}"
    x-data="multiselect()"
    data-multiselect-id="{{ $multiselectId }}"
    data-options='@json($options)'
    data-selected='@json($selected)'
    data-tag-bg="{{ $tagBg }}"
    data-tag-color="{{ $tagColor }}"
    data-tag-border-color="{{ $tagBorderColor }}"
    data-disabled="{{ $disabled ? '1' : '0' }}"
    data-allow-custom="{{ $allowCustom ? '1' : '0' }}"
    x-on:multiselect-toggle="toggleOption($event.detail.value)"
>
    <x-dropdown class="w-100 dropdown-root--trigger-full">
        <x-slot:trigger>
            <div
                class="{{ $wrapperClass }}"
                @if($disabled) aria-disabled="true" @endif
            >
                <div
                    class="{{ $triggerClass }}"
                    role="combobox"
                    aria-haspopup="listbox"
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
                                        :style="tagStyle(value)"
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
            </div>
        </x-slot:trigger>

        <div
            x-data="multiselectDropdownItems()"
            data-multiselect-options-id="{{ $multiselectId ?? '' }}"
        >
            @foreach($options as $value => $opt)
                @php
                    $label = is_array($opt) ? ($opt['label'] ?? (string) $value) : $opt;
                @endphp
                <button
                    type="button"
                    class="dropdown-item dropdown-item--none dropdown-item--default"
                    :class="{ 'dropdown-item--selected': selectedValues.includes('{{ (string) $value }}' }"
                    role="menuitem"
                    @click="$dispatch('multiselect-toggle', { value: '{{ (string) $value }}' })"
                >
                    <span class="dropdown-item__label">{{ $label }}</span>
                </button>
            @endforeach
        </div>
    </x-dropdown>

    @if($name)
        <input type="hidden" name="{{ $name }}" :value="selected.join(',')" class="multiselect-input" :disabled="disabled">
    @endif
    @if($error)
        <span class="input-error multiselect-error">{{ $error }}</span>
    @endif
</div>
