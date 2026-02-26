<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\DataShowcase;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class DataShowcasesDataTable extends BaseDataTable
{
    /**
     * @param  QueryBuilder<DataShowcase>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Редактировать'],
            ['label' => 'Удалить', 'state' => 'error'],
        ];

        return (new EloquentDataTable($query))
            ->addColumn('status_cell', function (DataShowcase $showcase) {
                return view('components.status-cell', [
                    'variant' => $showcase->status,
                ])->render();
            })
            ->addColumn('progress_cell', function (DataShowcase $showcase) {
                return $showcase->progress.'%';
            })
            ->addColumn('actions', function (DataShowcase $showcase) use ($dropdownItems) {
                return view('components.actions-cell', [
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['status_cell', 'actions'])
            ->setRowId('id');
    }

    /**
     * @return QueryBuilder<DataShowcase>
     */
    public function query(DataShowcase $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('data-showcases-table')
            ->columns($this->getColumns())
            ->orderBy(0)
            ->minifiedAjax();
    }

    /**
     * @return array<int, Column>
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')
                ->title('Название')
                ->addClass('column-name')
                ->width(249),
            Column::make('section')
                ->title('Раздел')
                ->addClass('column-section')
                ->width(180),
            Column::make('table_name')
                ->title('Таблица')
                ->addClass('column-table-name')
                ->width(180),
            Column::make('period')
                ->title('Период')
                ->addClass('column-period')
                ->width(180),
            Column::computed('status_cell')
                ->title('Статус')
                ->addClass('column-status')
                ->orderable(false)
                ->searchable(false)
                ->width(160),
            Column::make('row_count')
                ->title('Кол-во строк')
                ->addClass('column-row-count')
                ->width(160),
            Column::make('loaded_rows')
                ->title('Загружено строк')
                ->addClass('column-loaded-rows')
                ->width(200),
            Column::computed('progress_cell')
                ->title('Прогресс')
                ->addClass('column-progress')
                ->orderable(false)
                ->searchable(false)
                ->width(160),
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
        return 'витрины_данных_'.date('YmdHis');
    }
}
