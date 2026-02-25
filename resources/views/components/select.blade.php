@props([
    'text' => null,
    'value' => null,
    'label' => null,
    'placeholder' => 'Выбор папки',
    'leftIcon' => null,
    'rightIcon' => 'arrow_chevron_down',
    'type' => 'main',
    'state' => null,
    'disabled' => false,
    'error' => null,
    'cursor' => false,
    'options' => [],
    'class' => '',
])

@php
    $wrapperClass = 'input-wrapper select-wrapper';
    $wrapperClass .= $type === 'stroke' ? ' input-wrapper--stroke select-wrapper--stroke' : ' input-wrapper--main';
    if ($error) {
        $wrapperClass .= ' has-error';
    }
    if ($state === 'selected') {
        $wrapperClass .= ' state-selected';
    }

    $bodyClass = 'input-body select-body';
    $bodyClass .= $type === 'stroke' ? ' input-body--stroke select-body--stroke' : ' input-body--main select-body--main';
    $bodyClass .= ' ' . $class;

    $hasValue = $value || $text;
    $displayText = $text ?? $value ?? $placeholder;

    if ($disabled) {
        $bodyClass .= ' disabled';
        if ($label && $hasValue) {
            $bodyClass .= ' disabled-filled';
        }
    }

    if ($error) {
        $bodyClass .= ' error';
    }

    if ($state === 'hover') {
        $bodyClass .= ' hover';
    }

    \Log::debug('hasValue', [$hasValue]);
    if (! $hasValue) {
        $bodyClass .= ' select-empty input-empty';
    } elseif ($type === 'main') {
        $bodyClass .= ' state-filled';
    }
@endphp

<div
    class="d-flex flex-column {{ $error ? 'gap-1' : 'gap-0' }} position-relative"
    @if(!empty($options))
    x-data="selectDropdown()"
    x-on:click.outside="close()"
    data-initial-value="{{ $value ?? '' }}"
    data-placeholder="{{ e($placeholder) }}"
    @endif
>
    <div
        @if(!empty($options)) x-ref="selectWrapper" @endif
        class="{{ $wrapperClass }}"
        @if(!empty($options)) :class="{ 'state-selected': open, 'state-filled': selectedLabel, 'select-empty input-empty': !selectedLabel }" @endif
        @if($disabled) aria-disabled="true" @endif
    >
        <div
            class="{{ $bodyClass }}"
            @if(!empty($options)) :class="{ 'state-filled': selectedLabel, 'select-empty input-empty': !selectedLabel }" @endif
            @if(!empty($options)) @click.stop="toggle()" style="cursor: pointer;" @endif
        >
            @if($leftIcon)
                <span class="input-icon select-icon-left" aria-hidden="true">
                    <x-icon :name="$leftIcon" />
                </span>
            @endif

            <div class="input-content select-content flex-grow-1 min-w-0">
                @if($type === 'main')
                    <span class="input-label select-label">{{ $label ?? $placeholder }}</span>
                    <input
                        type="text"
                        class="input-field select-input"
                        @if(!empty($options))
                        x-bind:value="displayText"
                        @else
                        value="{{ $hasValue ? $displayText : '' }}"
                        @endif
                        data-placeholder="{{ $placeholder }}"
                        autocomplete="off"
                        aria-label="{{ $placeholder }}"
                        @if($disabled) disabled @endif
                        @if(!empty($options)) readonly @endif
                    />
                @else
                    @if($label)
                        <span class="input-label select-label">{{ $label }}</span>
                    @endif
                    @if(!empty($options))
                        <span class="select-text" x-text="displayText"></span>
                    @else
                        <span class="select-text">{{ $displayText }}</span>
                    @endif
                @endif
            </div>

            <span class="input-icons-right select-icon-right">
                <span class="input-icon"><x-icon :name="$rightIcon" /></span>
            </span>
        </div>

        @if(!empty($options))
            <div
                x-ref="panel"
                class="dropdown-panel select-dropdown"
                x-show="open"
                x-bind:style="panelStyle"
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
                    @foreach($options as $optVal => $optLabel)
                        @php
                            $label = is_array($optLabel) ? ($optLabel['label'] ?? $optVal) : $optLabel;
                        @endphp
                        <button
                            type="button"
                            class="dropdown-item dropdown-item--none"
                            :class="{ 'dropdown-item--selected': selectedValue == '{{ (string) $optVal }}' }"
                            role="option"
                            data-value="{{ $optVal }}"
                            data-label="{{ e($label) }}"
                            @click="selectOption($event.currentTarget.dataset.value, $event.currentTarget.dataset.label)"
                        >
                            <span class="dropdown-item__label">{{ $label }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    @if($error)
        <span class="input-error select-error">{{ $error }}</span>
    @endif
</div>
