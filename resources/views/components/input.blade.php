@props([
    'type' => 'main',
    'label' => null,
    'placeholder' => '',
    'name' => null,
    'id' => null,
    'value' => null,
    'disabled' => false,
    'error' => null,
    'leftIcon' => null,
    'rightIcon' => null,
    'inputType' => 'text',
    'class' => '',
])

@php
    $wrapperClass = 'input-wrapper';
    $wrapperClass .= $type === 'stroke' ? ' input-wrapper--stroke' : ' input-wrapper--main';
    $wrapperClass .= $error ? ' has-error' : '';
    $wrapperClass .= ' ' . $class;

    $bodyClass = 'input-body';
    $bodyClass .= $type === 'stroke' ? ' input-body--stroke' : ' input-body--main';
    $bodyClass .= $disabled ? ' disabled' : '';
    $bodyClass .= $error ? ' error' : '';
    if ($type === 'main') {
        $hasValue = old($name, $value) !== null && old($name, $value) !== '';
        $bodyClass .= $hasValue ? ' state-filled' : ' input-empty';
    }
    if ($type === 'stroke') {
        $bodyClass .= ($value !== null && $value !== '') ? ' state-filled' : ' input-empty';
    }

    $hasLeftIcon = $leftIcon !== null || (isset($iconLeft) && $iconLeft->isNotEmpty());
    $hasRightIcon = $rightIcon !== null || (isset($iconRight) && $iconRight->isNotEmpty()) || (isset($rightIcons) && $rightIcons->isNotEmpty());

    $inputId = $id ?? ($name ? 'input-' . preg_replace('/[^a-z0-9]+/i', '-', $name) . '-' . uniqid('', true) : 'input-' . uniqid('', true));
    $labelText = $label ?? $placeholder;
@endphp

<div @if($error) class="d-flex flex-column gap-1" @endif>
    <div
            class="{{ $wrapperClass }}"
            @if($type === 'main')
                x-data="{ hasValue: {{ (old($name, $value) !== null && old($name, $value) !== '') ? 'true' : 'false' }} }"
            x-init="hasValue = $refs.input && $refs.input.value.length > 0"
            @endif
            @if($disabled) aria-disabled="true" @endif
    >
        <div class="{{ $bodyClass }}" @if($type === 'main') x-bind:class="{ 'state-filled': hasValue }" @endif>
            @if($hasLeftIcon)
                <span class="input-icon input-icon--left" aria-hidden="true">
                @if(isset($iconLeft) && $iconLeft->isNotEmpty())
                        {{ $iconLeft }}
                    @else
                        <x-icon :name="$leftIcon" />
                    @endif
            </span>
            @endif

            <div class="input-content">
                @if($type === 'main' && $labelText)
                    <span class="input-label">{{ $labelText }}</span>
                @endif
                <input
                        id="{{ $inputId }}"
                        type="{{ $inputType }}"
                        name="{{ $name }}"
                        class="input-field"
                        placeholder="{{ $placeholder }}"
                        value="{{ old($name, $value) }}"
                        @if($disabled) disabled @endif
                        @if($type === 'main') x-ref="input" x-on:input="hasValue = $el.value.length > 0" @endif
                        {{ $attributes->except('class')->merge(['aria-invalid' => $error ? 'true' : 'false', 'aria-describedby' => $error ? $inputId . '-error' : null]) }}
                />
            </div>

            @if($hasRightIcon)
                <span class="input-icons-right">
                @if(isset($rightIcons) && $rightIcons->isNotEmpty())
                        {{ $rightIcons }}
                    @elseif(isset($iconRight) && $iconRight->isNotEmpty())
                        {{ $iconRight }}
                    @else
                        <span class="input-icon input-icon--right"><x-icon :name="$rightIcon" /></span>
                    @endif
            </span>
            @endif
        </div>
    </div>

    @if($error)
        <span id="{{ $inputId }}-error" class="input-error" role="alert">{{ $error }}</span>
    @endif
</div>
