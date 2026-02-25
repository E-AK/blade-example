<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\CustomTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class CustomTablesDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<CustomTable>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('view_url', function (CustomTable $customTable) {
                return Route::has('custom-tables.show')
                    ? route('custom-tables.show', ['custom_table' => $customTable->id])
                    : '';
            })
            ->addColumn('actions', function (CustomTable $customTable) {
                return view('components.custom-tables.actions-cell', [
                    'table' => $customTable,
                ])->render();
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<CustomTable>
     */
    public function query(CustomTable $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('custom-tables-table')
            ->columns($this->getColumns())
            ->orderBy(0)
            ->minifiedAjax();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array<int, Column>
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->hidden(),
            Column::make('name')
                ->title('Название таблицы')
                ->addClass('column-name'),
            Column::make('row_count')
                ->title('Количество строк')
                ->addClass('column-row-count'),
            Column::make('data_volume')
                ->title('Объем данных')
                ->addClass('column-data-volume'),
            Column::computed('actions')
                ->title('Действия')
                ->addClass('column-actions text-center')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'пользовательские_таблицы_'.date('YmdHis');
    }
}
