<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class UsersDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<User>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function (User $user) {
                return Blade::render(
                    '<div class="d-flex flex-row align-items-center gap-2 name-cell">
                <span style="width: 20px"><x-icon name="actions_profile" /></span>
                <span class="name-cell-text">{{ $name }}</span>
            </div>',
                    ['name' => $user->name]
                );
            })
            ->addColumn('accounts', function (User $user) {
                $accounts = $user->accounts;
                $total = $accounts->count();

                $displayedAccounts = $accounts->take(4);
                $tags = $displayedAccounts->map(function ($account) {
                    return Blade::render(
                        '<x-tag
                                :text="$text"
                                icon="left"
                                leftIcon="actions_home"
                                size="sm"
                            />',
                        ['text' => $account->name]
                    );
                })->toArray();

                if ($total > 4) {
                    $remaining = $total - 4;
                    $tags[] = Blade::render(
                        '<x-tag
                                :text="$text"
                                size="sm"
                            />',
                        ['text' => '+'.$remaining]
                    );
                }

                return '<div class="d-flex flex-row gap-2 users-tags-container" 
              data-total-tags="'.$total.'">'
                    .implode('', $tags).
                    '</div>';
            })
            ->rawColumns(['name', 'accounts'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with('accounts');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('users-table')
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
                ->addClass('column-name'),
            Column::computed('accounts')
                ->addClass('column-accounts users-column')
                ->title('Пользователи'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'пользователи_'.date('YmdHis');
    }
}
