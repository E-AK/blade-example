<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\SbisConnection;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class SbisDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<SbisConnection>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Сделать основным'],
            ['label' => 'Редактировать'],
            ['label' => 'Удалить', 'state' => 'error'],
        ];

        return (new EloquentDataTable($query))
            ->editColumn('protected_key', function (SbisConnection $connection) {
                return view('components.sbis.secret-cell', [
                    'value' => $connection->protected_key,
                    'columnName' => 'Защищенный ключ',
                ])->render();
            })
            ->editColumn('service_key', function (SbisConnection $connection) {
                return view('components.sbis.secret-cell', [
                    'value' => $connection->service_key,
                    'columnName' => 'Сервисный ключ',
                ])->render();
            })
            ->addColumn('actions', function (SbisConnection $connection) use ($dropdownItems) {
                return view('components.sbis.actions-cell', [
                    'id' => $connection->id,
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['protected_key', 'service_key', 'actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SbisConnection>
     */
    public function query(SbisConnection $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('sbis-connections-table')
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
            Column::make('id')
                ->title('id приложения')
                ->addClass('column-id'),
            Column::make('protected_key')
                ->title('Защищенный ключ')
                ->addClass('column-protected-key')
                ->searchable(false),
            Column::make('service_key')
                ->title('Сервисный ключ')
                ->addClass('column-service-key')
                ->searchable(false),
            Column::make('connection_type')
                ->title('Тип подключения')
                ->addClass('column-connection-type'),
            Column::make('organization')
                ->title('Организация')
                ->addClass('column-organization'),
            Column::make('comment')
                ->title('Комментарий')
                ->addClass('column-comment'),
            Column::computed('actions')
                ->title('Действия')
                ->addClass('column-actions text-center')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'sbis_подключения_'.date('YmdHis');
    }
}
