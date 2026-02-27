<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\PasswordManagerEntry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class PasswordManagerAccessDataTable extends BaseDataTable
{
    public function __construct()
    {
        parent::__construct();

        $this->htmlBuilder->parameters([
            'searching' => false,
        ]);
    }

    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<PasswordManagerEntry>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function (PasswordManagerEntry $entry) {
                $url = $entry->url ?? '';
                $urlHtml = $url !== ''
                    ? '<a href="'.e($url).'" class="password-manager-access-table__url" target="_blank" rel="noopener">'.e($url).'</a>'
                    : '';

                return '<div class="password-manager-access-table__name-cell">'.
                    '<span class="password-manager-access-table__name">'.e($entry->name ?? '').'</span>'.
                    ($urlHtml ? '<span class="password-manager-access-table__url-wrap">'.$urlHtml.'</span>' : '').
                    '</div>';
            })
            ->addColumn('employee', function (PasswordManagerEntry $entry) {
                return '—';
            })
            ->addColumn('email', function (PasswordManagerEntry $entry) {
                return '—';
            })
            ->editColumn('login', function (PasswordManagerEntry $entry) {
                return e($entry->login ?? '—');
            })
            ->editColumn('password', function (PasswordManagerEntry $entry) {
                return view('components.secret-cell', [
                    'value' => $entry->password ?? '',
                    'columnName' => 'Пароль',
                    'warningTooltip' => null,
                    'alertTooltip' => null,
                ])->render();
            })
            ->addColumn('entry_data', function (PasswordManagerEntry $entry) {
                return json_encode([
                    'id' => $entry->id,
                    'name' => $entry->name,
                    'url' => $entry->url ?? '',
                    'folder' => $entry->folder ?? '',
                    'login' => $entry->login ?? '',
                    'tag' => [],
                    'tags' => [],
                    'employees' => [],
                    'warning' => null,
                    'alert' => null,
                ]);
            })
            ->rawColumns(['name', 'employee', 'email', 'login', 'password', 'entry_data'])
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

        $accessType = request('access_type');
        if ($accessType === 'sent') {
            // TODO: filter entries shared by current user
        } elseif ($accessType === 'received') {
            // TODO: filter entries shared with current user
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('table password-manager-access-table')
            ->columns($this->getColumns())
            ->orderBy(0)
            ->ajax(route('services.password-manager.access-data'));
    }

    /**
     * Get DataTable options array for the table element (data-options).
     */
    public function getOptions(): array
    {
        $this->html();

        return $this->htmlBuilder->getOptions();
    }

    /**
     * @return array<int, Column>
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->hidden(),
            Column::make('name')
                ->title('Название')
                ->addClass('column-name')
                ->orderable(true)
                ->searchable(false)
                ->width('220px'),
            Column::computed('employee')
                ->title('Сотрудник')
                ->addClass('column-employee')
                ->orderable(false)
                ->searchable(false)
                ->width('220px'),
            Column::computed('email')
                ->title('Почта')
                ->addClass('column-email')
                ->orderable(false)
                ->searchable(false)
                ->width('220px'),
            Column::make('login')
                ->title('Логин')
                ->addClass('column-login')
                ->orderable(false)
                ->searchable(false)
                ->width('220px'),
            Column::make('password')
                ->title('Пароль')
                ->addClass('column-password')
                ->orderable(false)
                ->searchable(false)
                ->width('220px'),
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
        return 'управление_доступами_'.date('YmdHis');
    }
}
