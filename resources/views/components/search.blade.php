@props([
    'size' => 'md',
    'placeholder' => '',
    'value' => '',
    'selected' => false,
    'description' => '',
    'tags' => [],
    'clearable' => true,
    'class' => '',
])

@php
    $wrapperClass = 'input-wrapper search-wrapper';
    $wrapperClass .= $selected ? ' state-selected' : '';
    $wrapperClass .= $description ? ' has-description' : '';
    $wrapperClass .= ' ' . $class;

    $bodyClass = 'input-body search-body';
    $bodyClass .= ' search-body--' . $size;
    $bodyClass .= $value !== '' ? ' state-filled' : '';
    $bodyClass .= $selected ? ' state-selected' : '';
    $bodyClass .= !empty($tags) ? ' has-tags' : '';

    $iconSize = $size === 'lg' ? 20 : 16;
@endphp

<div class="{{ $wrapperClass }}">
    <div class="{{ $bodyClass }}">
        <span class="input-icon search-icon" aria-hidden="true">
            <x-icon name="action_search" :size="$iconSize" :color="$selected ? 'grey-1' : 'grey-3'" />
        </span>

        <div class="search-content input-content">
            @if(!empty($tags))
                <div class="search-tags">
                    @foreach($tags as $tag)
                        <span class="search-tag">
                            <span class="tag-text">{{ $tag }}</span>
                            <span class="search-tag-close">
                                <x-icon name="close" :size="$iconSize" color="grey-2" />
                            </span>
                        </span>
                    @endforeach
                </div>
            @endif

            <input
                type="search"
                class="input-field search-input"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                autocomplete="off"
                @if($selected) autofocus @endif
            >
        </div>

        @if($clearable)
            <span class="input-icon search-clear {{ $value === '' ? 'd-none' : '' }}" role="button" tabindex="0" aria-label="{{ __('Clear') }}">
                <x-icon name="validation_cross_circle" :size="$iconSize" color="black" />
            </span>
        @endif
    </div>

    @if($description)
        <span class="search-description">{{ $description }}</span>
    @endif
</div>
