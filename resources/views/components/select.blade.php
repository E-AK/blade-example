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

    $hasValue = $value !== null || ($text !== null && $text !== '');
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

    if (! $hasValue) {
        $bodyClass .= ' select-empty input-empty';
    } elseif ($type === 'main') {
        $bodyClass .= ' state-filled';
    }
@endphp

<div class="d-flex flex-column {{ $error ? 'gap-1' : 'gap-0' }}">
    <div class="{{ $wrapperClass }}" @if($disabled) aria-disabled="true" @endif>
        <div class="{{ $bodyClass }}">
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
                        value="{{ $hasValue ? $displayText : '' }}"
                        data-placeholder="{{ $placeholder }}"
                        autocomplete="off"
                        aria-label="{{ $placeholder }}"
                        @if($disabled) disabled @endif
                    />
                @else
                    @if($label)
                        <span class="input-label select-label">{{ $label }}</span>
                    @endif
                    <span class="select-text">{{ $displayText }}</span>
                @endif
            </div>

            <span class="input-icons-right select-icon-right">
                <span class="input-icon"><x-icon :name="$rightIcon" /></span>
            </span>
        </div>

        @if(!empty($options))
            <ul class="input-dropdown select-dropdown list-unstyled m-0">
                @foreach($options as $val => $lab)
                    <li class="input-dropdown-item select-item" data-value="{{ $val }}">{{ $lab }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    @if($error)
        <span class="input-error select-error">{{ $error }}</span>
    @endif
</div>
