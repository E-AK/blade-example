@props([
    'shortUrl' => '',
])

<div class="d-flex gap-2 align-items-center short-link-cell justify-content-between">
    <a href="{{ $shortUrl }}" target="_blank" rel="noopener noreferrer" class="text-truncate text-blue short-link-cell__url text-decoration-none">
        {{ $shortUrl }}
    </a>
    <x-button
        type="string"
        size="small"
        icon-position="only"
        class="short-link-cell__copy"
        :extra-attributes="[
            'x-on:click' => 'navigator.clipboard.writeText(\''.e($shortUrl).'\'); if (window.Toast) window.Toast.success(\'Ссылка скопирована\')',
            'aria-label' => __('Copy'),
        ]"
    >
        <x-slot:icon>
            <x-icon name="document_copy" :size="20" />
        </x-slot:icon>
    </x-button>
</div>
