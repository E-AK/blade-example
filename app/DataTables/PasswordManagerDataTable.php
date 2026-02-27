<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\PasswordManagerEntry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class PasswordManagerDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<PasswordManagerEntry>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('url', function (PasswordManagerEntry $entry) {
                $url = $entry->url ?? '';

                return $url !== ''
                    ? view('components.short-link-cell', ['shortUrl' => $url])->render()
                    : '';
            })
            ->editColumn('password', function (PasswordManagerEntry $entry) {
                $warningTooltip = null;
                if ($entry->updated_at && $entry->updated_at->lt(now()->subMonths(6))) {
                    $warningTooltip = 'Пароль не обновлялся 6 месяцев';
                }

                return view('components.secret-cell', [
                    'value' => $entry->password,
                    'columnName' => 'Пароль',
                    'warningTooltip' => $warningTooltip,
                    'alertTooltip' => null,
                ])->render();
            })
            ->addColumn('tags', function (PasswordManagerEntry $entry) {
                return '';
            })
            ->addColumn('entry_data', function (PasswordManagerEntry $entry) {
                $warning = null;
                $alert = null;
                if ($entry->updated_at && $entry->updated_at->lt(now()->subMonths(6))) {
                    $warning = 'Пароль не обновлялся 6 месяцев';
                }

                return json_encode([
                    'id' => $entry->id,
                    'name' => $entry->name,
                    'url' => $entry->url ?? '',
                    'folder' => $entry->folder ?? '',
                    'login' => $entry->login ?? '',
                    'tag' => [],
                    'tags' => [],
                    'employees' => [],
                    'warning' => $warning,
                    'alert' => $alert,
                ]);
            })
            ->rawColumns(['url', 'password', 'tags', 'entry_data'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<PasswordManagerEntry>
     */
    public function query(PasswordManagerEntry $model): QueryBuilder
    {
        $query = $model->newQuery();

        if (request()->boolean('deleted_only')) {
            return $query->onlyTrashed();
        }

        $folder = request()->input('folder');
        if (is_string($folder) && $folder !== '') {
            $query->where('folder', $folder);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('password-manager-table')
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
                ->title('Название')
                ->addClass('column-name')
                ->width(256),
            Column::make('url')
                ->title('URL')
                ->addClass('column-url')
                ->width(256),
            Column::make('login')
                ->title('Логин')
                ->addClass('column-login')
                ->width(256),
            Column::make('password')
                ->title('Пароль')
                ->addClass('column-password')
                ->searchable(false)
                ->orderable(false)
                ->width(256),
            Column::computed('tags')
                ->title('Теги')
                ->addClass('column-tags')
                ->orderable(false)
                ->searchable(false)
                ->width(256),
            Column::computed('entry_data')
                ->title('')
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('d-none'),
        ];
    }

    protected function filename(): string
    {
        return 'менеджер_паролей_'.date('YmdHis');
    }
}
