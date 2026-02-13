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
    $wrapperClasses = $selected ? 'state-selected' : '';
    $wrapperClasses .= $description ? ' has-description' : '';

    $searchClasses = 'search-box search-box-' . $size;
    $searchClasses .= ' '.$class;
    if ($value !== '') $searchClasses .= ' state-filled';
    if ($selected) $searchClasses .= ' state-selected';
    if (!empty($tags)) $searchClasses .= ' has-tags';

    $iconSize = $size === 'lg' ? 20 : 16;
    $leftIconColor = $selected ? 'grey-1' : 'grey-3';
@endphp

<div class="search-wrapper {{ $wrapperClasses }}">
    <div class="{{ $searchClasses }}">
        <span class="search-icon">
            <x-icon :name="'action_search'" :size="$iconSize" :color="$leftIconColor" />
        </span>

        @if(!empty($tags))
            <div class="search-tags">
                @foreach($tags as $tag)
                    <span class="search-tag">
                        <span class="tag-text">{{ $tag }}</span>
                        <span class="tag-close">
                            <x-icon name="close" :size="$size === 'lg' ? 20 : 16" color="grey-2" />
                        </span>
                    </span>
                @endforeach
            </div>
        @endif

        @if($value === '' && empty($tags))
            <input
                    type="text"
                    class="search-input"
                    placeholder="{{ $placeholder }}"
                    value=""
                    @if($selected) autofocus @endif
            >
        @else
            <span class="search-text">{{ $value }}</span>
        @endif

        @if($clearable && $value !== '')
            <span class="search-clear">
                <x-icon name="validation_cross_circle" :size="$iconSize" color="black" />
            </span>
        @endif
    </div>

    @if($description)
        <span class="search-description">{{ $description }}</span>
    @endif
</div>