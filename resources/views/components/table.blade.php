@props([
    'filterSlot' => '',
])

@php
    $columns = $dataTable->getColumns();
    $options = $dataTable->getOptions();
@endphp

<div class="data-table">
    <div class="row align-items-center gap-3" style="padding-bottom: 20px">
        <div class="col-8" style="max-width: 720px">
            <x-search :class=" $searchClass" size="lg" :placeholder="$searchPlaceholder" />
        </div>
        <div class="col-4">
            {{ $filterSlot }}
        </div>
    </div>
    <table
        class="table"
        data-options='@json($options)'
        @if($hasSidebar) data-sidebar="true" @endif
    >

    </table>
</div>

