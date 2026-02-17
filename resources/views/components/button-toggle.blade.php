@props([
    'class' => '',
])

<div
    {{ $attributes->merge(['class' => 'button-toggle ' . $class]) }}
    role="group"
    x-data="buttonToggle()"
    x-init="syncState()"
    @change="syncState()"
>
    {{ $slot }}
</div>
