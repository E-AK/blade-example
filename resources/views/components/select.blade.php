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
    $wrapperClass = 'select-wrapper';
    $selectClass = 'select d-flex align-items-center';
    $selectClass .= $type === 'stroke' ? ' select-stroke' : ' select-main';
    $selectClass .= ' '.$class;

    $hasValue = $value !== null || ($text !== null && $text !== '');
    $displayText = $text ?? $value ?? $placeholder;

    if ($disabled) {
        $selectClass .= ' disabled';
        if ($label && $hasValue) {
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

    if (! $hasValue) {
        $selectClass .= ' select-empty';
    } elseif ($type === 'main') {
        $selectClass .= ' state-filled';
    }
@endphp

<div class="{{ $wrapperClass }}" @if($disabled) aria-disabled="true" @endif>
    <div class="{{ $selectClass }}">
        @if($leftIcon)
            <span class="select-icon-left">
                <x-icon :name="$leftIcon" />
            </span>
        @endif

        <div class="select-content flex-grow-1 min-w-0">
            @if($type === 'main')
                <span class="select-label">{{ $label ?? $placeholder }}</span>
                <input
                    type="text"
                    class="select-input"
                    value="{{ $hasValue ? $displayText : '' }}"
                    data-placeholder="{{ $placeholder }}"
                    autocomplete="off"
                    aria-label="{{ $placeholder }}"
                    @if($disabled) disabled @endif
                />
            @else
                @if($label)
                    <span class="select-label">{{ $label }}</span>
                @endif
                <span class="select-text">{{ $displayText }}</span>
            @endif
        </div>

        <span class="select-icon-right">
            <x-icon :name="$rightIcon" />
        </span>
    </div>

    @if($error)
        <span class="select-error">{{ $error }}</span>
    @endif

    @if(!empty($options))
        <ul class="select-dropdown list-unstyled m-0 border rounded shadow-sm">
            @foreach($options as $val => $lab)
                <li class="select-item px-3 py-2" data-value="{{ $val }}">{{ $lab }}</li>
            @endforeach
        </ul>
    @endif
</div>