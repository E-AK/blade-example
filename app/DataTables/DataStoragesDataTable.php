<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\DataStorage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class DataStoragesDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<DataStorage>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Сгенерировать новый пароль'],
            ['label' => 'Редактировать'],
        ];

        return (new EloquentDataTable($query))
            ->editColumn('password', function (DataStorage $dataStorage) {
                return view('components.sbis.secret-cell', [
                    'value' => $dataStorage->password,
                    'columnName' => 'Пароль',
                ])->render();
            })
            ->addColumn('actions', function (DataStorage $dataStorage) use ($dropdownItems) {
                return view('components.sbis.actions-cell', [
                    'id' => $dataStorage->id,
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['password', 'actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<DataStorage>
     */
    public function query(DataStorage $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('data-storages-table')
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
            Column::make('server_address')
                ->title('Адрес сервера')
                ->addClass('column-server-address'),
            Column::make('database_name')
                ->title('Имя базы данных')
                ->addClass('column-database-name'),
            Column::make('user')
                ->title('Пользователь')
                ->addClass('column-user'),
            Column::make('password')
                ->title('Пароль')
                ->addClass('column-password')
                ->searchable(false)
                ->orderable(false),
            Column::make('ip_access')
                ->title('Доступ по IP')
                ->addClass('column-ip-access'),
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
        return 'хранилище_данных_'.date('YmdHis');
    }
}
