<?php

namespace App\DataTables;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class AccountsDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Account>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('users', function (Account $account) {
                return Str::limit($account->users->pluck('name')->join(', '), 30);
            })
            ->addColumn('active', function (Account $account) {
                return $account->active ? 'Активный' : 'Неактивный';
            })
            ->filterColumn('active', function (QueryBuilder $query, $value) {
                $query->where('active', $value === 'true');
            })
            ->orderColumn('active', function (QueryBuilder $query, $order) {
                $query->orderBy('active', $order);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Account>
     */
    public function query(Account $model): QueryBuilder
    {
        return $model->newQuery()->with('users');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->orderBy(0)
            ->minifiedAjax();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->hidden(),
            Column::make('name')
                ->title('Название')
                ->searchable(true),
            Column::computed('users')
                ->title('Пользователи'),
            Column::make('active')
                ->title('Статус')
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'аккаунты_'.date('YmdHis');
    }
}
