@props([
    'class' => '',
])

<span
    {{ $attributes->merge(['class' => 'drag-handle ' . trim($class), 'title' => 'Перетащить']) }}
>
    <x-icon name="arrow_six_dot_vertical" :size="16" />
</span>
