@props([
    'class' => '',
])

<div
    {{ $attributes->merge(['class' => 'button-toggle ' . $class]) }}
    role="group"
>
    {{ $slot }}
</div>
