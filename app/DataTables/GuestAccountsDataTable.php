<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\GuestAccount;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class GuestAccountsDataTable extends BaseDataTable
{
    /**
     * @param  QueryBuilder<GuestAccount>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Редактировать'],
            ['label' => 'Удалить', 'state' => 'error'],
        ];

        return (new EloquentDataTable($query))
            ->editColumn('email', function (GuestAccount $guest) {
                return e($guest->email);
            })
            ->editColumn('connections', fn (GuestAccount $guest) => $guest->connections ? 'Да' : 'Нет')
            ->editColumn('data_collection', fn (GuestAccount $guest) => $guest->data_collection ? 'Да' : 'Нет')
            ->editColumn('custom_tables', fn (GuestAccount $guest) => $guest->custom_tables ? 'Да' : 'Нет')
            ->editColumn('services', fn (GuestAccount $guest) => $guest->services ? 'Да' : 'Нет')
            ->editColumn('event_chains', fn (GuestAccount $guest) => $guest->event_chains ? 'Да' : 'Нет')
            ->editColumn('reports', fn (GuestAccount $guest) => $guest->reports ? 'Да' : 'Нет')
            ->addColumn('actions', function (GuestAccount $guest) use ($dropdownItems) {
                return view('components.actions-cell', [
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    /**
     * @return QueryBuilder<GuestAccount>
     */
    public function query(GuestAccount $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('guest-accounts-table')
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
            Column::make('id')->hidden(),
            Column::make('email')
                ->title('Email')
                ->addClass('column-email')
                ->width('210px'),
            Column::make('connections')
                ->title('Подключения')
                ->addClass('column-connections')
                ->width('210px')
                ->searchable(false),
            Column::make('data_collection')
                ->title('Сбор информации')
                ->addClass('column-data-collection')
                ->width('210px')
                ->searchable(false),
            Column::make('custom_tables')
                ->title('Пользовательские таблицы')
                ->addClass('column-custom-tables')
                ->width('210px')
                ->searchable(false),
            Column::make('services')
                ->title('Сервисы')
                ->addClass('column-services')
                ->width('210px')
                ->searchable(false),
            Column::make('event_chains')
                ->title('Цепочки событий')
                ->addClass('column-event-chains')
                ->width('210px')
                ->searchable(false),
            Column::make('reports')
                ->title('Отчеты')
                ->addClass('column-reports')
                ->width('210px')
                ->searchable(false),
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
        return 'гостевые_аккаунты_'.date('YmdHis');
    }
}
