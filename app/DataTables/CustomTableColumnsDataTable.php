<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\CustomTableColumn;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class CustomTableColumnsDataTable extends BaseDataTable
{
    public int $custom_table_id;

    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<CustomTableColumn>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Редактировать'],
            ['label' => 'Удалить', 'state' => 'error'],
        ];

        return (new EloquentDataTable($query))
            ->editColumn('is_required', function (CustomTableColumn $column) {
                return $column->is_required ? 'Обязательное' : 'Не обязательное';
            })
            ->addColumn('actions', function (CustomTableColumn $column) use ($dropdownItems) {
                return view('components.sbis.actions-cell', [
                    'id' => $column->id,
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<CustomTableColumn>
     */
    public function query(CustomTableColumn $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('custom_table_id', $this->custom_table_id)
            ->orderBy('sort_order');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('custom-table-columns-table')
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
            Column::make('sort_order')
                ->title('Позиция')
                ->addClass('column-sort-order')
                ->width('104px'),
            Column::make('name')
                ->title('Название колонки')
                ->addClass('column-name')
                ->width('156px'),
            Column::make('type')
                ->title('Тип данных в БД')
                ->addClass('column-type')
                ->width('156px'),
            Column::make('data_type')
                ->title('Тип данных')
                ->addClass('column-data-type')
                ->width('156px'),
            Column::make('example_data')
                ->title('Пример данных')
                ->addClass('column-example-data')
                ->width('112px'),
            Column::make('is_required')
                ->title('Необходимость заполнения')
                ->addClass('column-is-required')
                ->width('156px'),
            Column::make('comment')
                ->title('Комментарий')
                ->addClass('column-comment')
                ->width('149px'),
            Column::computed('actions')
                ->title('Действия')
                ->addClass('column-actions text-center')
                ->orderable(false)
                ->searchable(false)
                ->width('91px'),
        ];
    }

    protected function filename(): string
    {
        return 'колонки_таблицы_'.date('YmdHis');
    }
}
