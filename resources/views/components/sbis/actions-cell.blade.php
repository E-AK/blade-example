@props([
    'id' => '',
    'items' => [],
])

<div
    class="position-relative d-inline-block dropdown-trigger-wrapper"
    x-data="dropdown()"
    x-on:click.outside="close()"
    x-on:dropdown-close-others.window="$event.detail !== _dropdownId && close()"
    x-bind:class="open ? 'open' : ''"
>
    <x-button
        type="string"
        size="small"
        icon-position="only"
        :extra-attributes="['x-on:click.stop' => 'toggle()', 'aria-haspopup' => 'true', 'x-bind:aria-expanded' => 'open']"
    >
        <x-slot:icon>
            <x-icon name="arrow_three_dot_vertical" :size="20" />
        </x-slot:icon>
    </x-button>
    <x-dropdown :items="$items" :id="'sbis-dropdown-'.$id" :for-action-cell="true" @click.stop />
</div>
