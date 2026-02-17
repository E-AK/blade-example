@props([
    'stepNumber' => 1,
    'stepLabel' => 'Шаг 1',
    'title' => 'Заголовок',
    'state' => 'default',
    'isLast' => false,
    'class' => '',
])

@php
    $state = in_array($state, ['default', 'active', 'success', 'error'], true) ? $state : 'default';
@endphp

<div
    {{ $attributes->merge(['class' => 'stepper-item ' . $class]) }}
    data-state="{{ $state }}"
    @if($isLast) data-last="true" @endif
>
    <div class="stepper-item__content">
        <span class="stepper-item__circle" aria-hidden="true">
            @if($state === 'success')
                <x-icon name="validation_check" class="stepper-item__icon stepper-item__icon--check" color="white" aria-hidden="true" />
            @elseif($state === 'error')
                <x-icon name="arrow_close" class="stepper-item__icon stepper-item__icon--close" color="white" aria-hidden="true" />
            @else
                <span class="stepper-item__number">{{ $stepNumber }}</span>
            @endif
        </span>
        <div class="stepper-item__labels">
            <span class="stepper-item__step-label">{{ $stepLabel }}</span>
            <span class="stepper-item__title">{{ $title }}</span>
        </div>
    </div>
    @if(!$isLast)
        <span class="stepper-item__connector" aria-hidden="true"></span>
    @endif
</div>
