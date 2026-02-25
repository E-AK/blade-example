<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\ImportTask;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class ImportSettingsDataTable extends BaseDataTable
{
    /**
     * @param  QueryBuilder<ImportTask>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Редактировать'],
            ['label' => 'Удалить', 'state' => 'error'],
        ];

        return (new EloquentDataTable($query))
            ->editColumn('collect_from_date', function (ImportTask $task) {
                return $task->collect_from_date ? 'Да' : 'Нет';
            })
            ->editColumn('period_start_date', function (ImportTask $task) {
                return $task->period_start_date?->format('d.m.Y') ?? '—';
            })
            ->editColumn('period_end_date', function (ImportTask $task) {
                return $task->period_end_date?->format('d.m.Y') ?? '—';
            })
            ->addColumn('webhooks', function (ImportTask $task) {
                return view('components.import-settings.webhook-cell', [
                    'webhookMode' => $task->webhook_mode,
                    'name' => 'webhook_'.$task->id,
                ])->render();
            })
            ->addColumn('status_cell', function (ImportTask $task) {
                return view('components.import-settings.status-cell', [
                    'variant' => $task->status,
                ])->render();
            })
            ->addColumn('actions', function (ImportTask $task) use ($dropdownItems) {
                return view('components.sbis.actions-cell', [
                    'id' => $task->id,
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['webhooks', 'status_cell', 'actions'])
            ->setRowId('id');
    }

    /**
     * @return QueryBuilder<ImportTask>
     */
    public function query(ImportTask $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('import-settings-table')
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
            Column::make('command')
                ->title('Команда')
                ->addClass('column-command'),
            Column::make('collect_from_date')
                ->title('Собирать данные с указанной даты')
                ->addClass('column-collect-from-date')
                ->searchable(false),
            Column::make('period_start_date')
                ->title('Дата начала периода данных')
                ->addClass('column-period-start-date')
                ->searchable(false),
            Column::make('period_end_date')
                ->title('Дата окончания периода данных')
                ->addClass('column-period-end-date')
                ->searchable(false),
            Column::make('records_count')
                ->title('Количество записей')
                ->addClass('column-records-count'),
            Column::computed('webhooks')
                ->title('Вебхуки')
                ->addClass('column-webhooks')
                ->orderable(false)
                ->searchable(false),
            Column::computed('status_cell')
                ->title('Статус')
                ->addClass('column-status')
                ->orderable(false)
                ->searchable(false),
            Column::computed('actions')
                ->title('Действия')
                ->addClass('column-actions text-center')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'настройка_импорта_данных_'.date('YmdHis');
    }
}
