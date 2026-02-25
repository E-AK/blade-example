<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\CustomTableColumn;
use App\Models\CustomTableRow;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class CustomTableDataDataTable extends BaseDataTable
{
    public int $custom_table_id;

    /**
     * @return Collection<int, CustomTableColumn>
     */
    private function tableColumns(): Collection
    {
        return CustomTableColumn::query()
            ->where('custom_table_id', $this->custom_table_id)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * @param  QueryBuilder<CustomTableRow>  $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $tableColumns = $this->tableColumns();
        $dataTable = new EloquentDataTable($query);

        foreach ($tableColumns as $column) {
            $columnId = $column->id;
            $dataTable->addColumn('col_'.$columnId, function (CustomTableRow $row) use ($columnId) {
                return e((string) $row->getValueForColumn($columnId));
            });
        }

        $dropdownItems = [
            ['label' => 'Редактировать'],
            ['label' => 'Удалить', 'state' => 'error'],
        ];

        $dataTable->addColumn('actions', function (CustomTableRow $row) use ($dropdownItems) {
            return view('components.sbis.actions-cell', [
                'id' => $row->id,
                'items' => $dropdownItems,
            ])->render();
        });

        return $dataTable->rawColumns(['actions'])->setRowId('id');
    }

    /**
     * @return QueryBuilder<CustomTableRow>
     */
    public function query(CustomTableRow $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('custom_table_id', $this->custom_table_id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('custom-table-data-table')
            ->columns($this->getColumns())
            ->orderBy(0)
            ->minifiedAjax();
    }

    /**
     * @return array<int, Column>
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id')->hidden(),
        ];

        foreach ($this->tableColumns() as $column) {
            $columns[] = Column::make('col_'.$column->id)
                ->title($column->name)
                ->addClass('column-data')
                ->orderable(false)
                ->searchable(true);
        }

        $columns[] = Column::computed('actions')
            ->title('Действия')
            ->addClass('column-actions text-center')
            ->orderable(false)
            ->searchable(false)
            ->width('91px');

        return $columns;
    }

    protected function filename(): string
    {
        return 'данные_таблицы_'.date('YmdHis');
    }
}
