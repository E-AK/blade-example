@use('Illuminate\Support\Facades\Route')
@props([
    'table',
])

@php
    $editUrl = Route::has('custom-tables.edit')
        ? route('custom-tables.edit', ['custom_table' => $table->id])
        : '#';
@endphp

<x-actions-cell>
    <a
        href="{{ $editUrl }}"
        class="dropdown-item dropdown-item--none dropdown-item--default dropdown-item--actions"
        role="menuitem"
    >
        <span class="dropdown-item__label">Редактировать</span>
    </a>
    <button
        type="button"
        class="dropdown-item dropdown-item--none dropdown-item--error dropdown-item--actions"
        role="menuitem"
        data-id="{{ (int) $table->id }}"
        data-name="{{ e($table->name) }}"
        data-row-count="{{ (int) $table->row_count }}"
        @click="$dispatch('custom-table-delete', { id: parseInt($el.dataset.id, 10), name: $el.dataset.name, row_count: parseInt($el.dataset.rowCount, 10) })"
    >
        <span class="dropdown-item__label">Удалить</span>
    </button>
</x-actions-cell>
