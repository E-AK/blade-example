@props([
    'name' => 'switch',
    'checked' => false,
    'label' => '',
])

<div class="d-flex gap-2 align-items-center">
    <x-switch
        :name="$name"
        size="small"
        :checked="$checked"
    />
    @if($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
</div>
