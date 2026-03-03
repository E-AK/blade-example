@props([
    'filterSlot' => '',
])

@php
    $columns = $dataTable->getColumns();
    $options = $dataTable->getOptions();
@endphp

<div class="data-table">
    @if($showSearch)
        <div class="row align-items-center data-table__search-row">
            <div class="col-8 data-table__search-col {{ $searchWidth ? 'data-table__search-col--custom' : '' }}" @if($searchWidth) style="--data-table-search-width: {{ $searchWidth }}" @endif>
                @if(isset($search) && $search->isNotEmpty())
                    {{ $search }}
                @else
                    <x-search :class="$searchClass" size="lg" :placeholder="$searchPlaceholder" :pilled="$searchPilled" />
                @endif
            </div>
            <div class="col-4">
                {{ $filterSlot }}
            </div>
        </div>
    @endif
    <table
        class="table"
        data-options='@json($options)'
        @if($hasSidebar) data-sidebar="true" @endif
        @if($sidebarLabel) data-sidebar-label="{{ e($sidebarLabel) }}" @endif
    >

    </table>
</div>

