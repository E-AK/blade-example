@props([
    'class' => '',
])

<nav
    {{ $attributes->merge(['class' => 'stepper ' . $class]) }}
    aria-label="{{ __('Step progress') }}"
>
    {{ $slot }}
</nav>
