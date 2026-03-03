@props([
    'gap' => '12', // 1, 3, 12
    'direction' => 'column', // column, row
])

@php
    $gapClass = match($gap) {
        '1' => 'stack--gap-1',
        '3' => 'stack--gap-3',
        default => 'stack--gap-12',
    };
    $directionClass = $direction === 'row' ? 'stack-row--gap-12' : 'stack';
    $baseClass = $direction === 'row' ? 'stack-row--gap-12' : 'stack ' . $gapClass;
@endphp

<div {{ $attributes->merge(['class' => $baseClass]) }}>
    {{ $slot }}
</div>
