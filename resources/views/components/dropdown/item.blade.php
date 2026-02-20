@props([
    'label' => '',
    'sublabel' => null,
    'icon' => 'none',
    'iconName' => null,
    'state' => 'default',
    'checked' => false,
    'disabled' => false,
    'error' => false,
    'actions' => false,
    'url' => null,
])

@php
    $isDisabled = $disabled || $state === 'disabled';
    $isError = $error || $state === 'error';
    $tag = $url ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if($url) href="{{ $url }}" @else type="button" @endif
    class="dropdown-item dropdown-item--{{ $icon }} dropdown-item--{{ $state }} {{ $actions ? 'dropdown-item--actions' : '' }} {{ $isError ? 'dropdown-item--error' : '' }}"
    role="menuitem"
    @disabled($isDisabled)
    @if($isDisabled) aria-disabled="true" @endif
    {{ $attributes }}
>
    @if(in_array($icon, ['left', 'both', 'controllers'], true))
        @if($icon === 'controllers')
            <x-checkbox
                :checked="$checked"
                :disabled="$isDisabled"
                size="20"
                class="dropdown-item__control"
            />
        @elseif($iconName)
            <span class="dropdown-item__icon dropdown-item__icon--left">
                <x-icon :name="$iconName" :size="20" />
            </span>
        @else
            <span class="dropdown-item__icon dropdown-item__icon--left dropdown-item__icon--placeholder" aria-hidden="true"></span>
        @endif
    @endif

    @if($icon === 'label')
        <div class="dropdown-item__content dropdown-item__content--label">
            @if($sublabel)
                <span class="dropdown-item__sublabel">{{ $sublabel }}</span>
            @endif
            <span class="dropdown-item__label">{{ $label }}</span>
        </div>
    @else
        <span class="dropdown-item__label">{{ $label }}</span>
    @endif

    @if(in_array($icon, ['right', 'both'], true))
        <span class="dropdown-item__icon dropdown-item__icon--right">
            <x-icon name="arrow_right" :size="20" />
        </span>
    @endif
</{{ $tag }}>
