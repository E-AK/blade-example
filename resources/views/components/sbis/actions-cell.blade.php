@props([
    'id' => '',
    'items' => [],
])

<x-dropdown :items="$items" :actions="true" class="dropdown-trigger-wrapper">
    <x-slot:trigger>
        <x-button
            type="string"
            size="small"
            icon-position="only"
            :extra-attributes="['aria-haspopup' => 'true']"
        >
            <x-slot:icon>
                <x-icon name="arrow_three_dot_vertical" :size="20" />
            </x-slot:icon>
        </x-button>
    </x-slot:trigger>
</x-dropdown>
