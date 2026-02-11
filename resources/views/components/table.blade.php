@props([
    'filterSlot' => '',
])

@php
    $columns = $dataTable->getColumns();
    $options = $dataTable->getOptions();
@endphp

<div class="data-table">
    <div class="row align-items-center gap-3" style="padding-bottom: 20px">
        <div class="col-8" style="max-width: 720px"> <!-- TODO: to scss -->
            <x-search :placeholder="$searchPlaceholder" />
        </div>
        <div class="col-4">
            {{ $filterSlot }}
        </div>
    </div>
    <table class="table" data-options='@json($options)'>
        <thead class="table-header">
            <tr>
                @foreach ($columns as $column)
{{--                    @if ($column['attributes']['visible'] ?? false === false)--}}
{{--                        @continue--}}
{{--                    @endif--}}
                    <th>{{ $column['title'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

