@props([
    'webhookMode' => 'send',
    'name' => 'webhook_mode',
])

<div class="d-flex gap-2 align-items-center">
    <x-switch
        :name="$name"
        size="small"
        :checked="$webhookMode === 'send'"
    />
    <label for="{{ $name }}">Отправлять</label>
</div>
