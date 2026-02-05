@props([
    'filterSlot' => '',
])

@php
    $columns = $dataTable->getColumns();
    $options = $dataTable->getOptions();
@endphp

<div class="data-table">
    <div class="row align-items-center">
        <div class="col-8">
            <div class="search-box input-group col-4">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="{{ $options['language']['search'] ?? 'Поиск...' }}" aria-label="Search" aria-describedby="basic-addon1">
            </div>
        </div>
        <div class="col-4">
            {{ $filterSlot }}
        </div>
    </div>
    <table class="table" data-options='@json($options)'>
        <thead class="table-header">
            <tr>
                @foreach ($columns as $column)
                    @if ($column['attributes']['visible'] ?? false === false)
                        @continue
                    @endif
                    <th>{{ $column['title'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{-- Table body will be populated by DataTables --}}
        </tbody>
    </table>
</div>

