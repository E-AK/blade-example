<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class AccountsDataTable extends BaseDataTable
{
    protected bool $includeActiveColumn = true;

    /**
     * Exclude the active (status) column from the table.
     */
    public function withoutActiveColumn(): static
    {
        $this->includeActiveColumn = false;

        return $this;
    }

    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Account>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $table = (new EloquentDataTable($query))
            ->editColumn('name', function (Account $account) {
                return Blade::render(
                    '<div class="d-flex flex-row align-items-center gap-2 name-cell">
                <span style="width: 20px"><x-icon name="actions_home" /></span>
                <span class="name-cell-text">{{ $name }}</span>
            </div>',
                    ['name' => $account->name]
                );
            })
            ->addColumn('users', function (Account $account) {
                $users = $account->users;
                $total = $users->count();

                $displayedUsers = $users->take(4);
                $tags = $displayedUsers->map(function ($user) {
                    return Blade::render(
                        '<x-tag 
                                :text="$text"
                                :showLeftIcon="true"
                                icon="left"
                                leftIcon="actions_crown"
                                size="sm"
                            />',
                        ['text' => $user->name]
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
            });

        $rawColumns = ['name', 'users'];

        if ($this->includeActiveColumn) {
            $table->addColumn('active', function (Account $account) {
                $variant = $account->active ? 'success' : 'pause';

                return Blade::render('<div class="d-flex flex-row users-cell"><x-status :variant="$variant" /></div>', [
                    'variant' => $variant,
                ]);
            });
            $rawColumns[] = 'active';
            $table->filterColumn('active', function (QueryBuilder $query, $value) {
                $query->where('active', $value === 'true');
            });
            $table->orderColumn('active', function (QueryBuilder $query, $order) {
                $query->orderBy('active', $order);
            });
        }

        return $table->rawColumns($rawColumns)->setRowId('id');
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
            ->addTableClass('accounts-table')
            ->columns($this->getColumns())
            ->orderBy(0)
            ->minifiedAjax();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id')
                ->hidden(),
            Column::make('name')
                ->title('Название')
                ->addClass('column-name')
                ->width('320px'),
            Column::computed('users')
                ->addClass('column-users')
                ->title('Пользователи')
        ];

        if ($this->includeActiveColumn) {
            $columns[] = Column::make('active')
                ->title('Статус')
                ->addClass('column-status')
                ->searchable(false)
                ->width('160px');
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'аккаунты_'.date('YmdHis');
    }
}
