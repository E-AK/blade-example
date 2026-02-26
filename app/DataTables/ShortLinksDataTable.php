<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class ShortLinksDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<ShortLink>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dropdownItems = [
            ['label' => 'Редактировать'],
            ['label' => 'Удалить'],
        ];

        return (new EloquentDataTable($query))
            ->editColumn('original_url', function (ShortLink $shortLink) {
                return '<span class="text-truncate d-inline-block" style="max-width: 100%;" title="'.e($shortLink->original_url).'">'.e($shortLink->original_url).'</span>';
            })
            ->editColumn('short_url', function (ShortLink $shortLink) {
                return view('components.short-link-cell', [
                    'shortUrl' => $shortLink->short_url,
                ])->render();
            })
            ->editColumn('comment', function (ShortLink $shortLink) {
                return $shortLink->comment ?? '–';
            })
            ->addColumn('actions', function (ShortLink $shortLink) use ($dropdownItems) {
                return view('components.actions-cell', [
                    'items' => $dropdownItems,
                ])->render();
            })
            ->rawColumns(['original_url', 'short_url', 'actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ShortLink>
     */
    public function query(ShortLink $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('short-links-table')
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
            Column::make('original_url')
                ->title('Ссылка')
                ->addClass('column-original-url')
                ->width(365),
            Column::make('short_url')
                ->title('Сокращенная ссылка')
                ->addClass('column-short-url')
                ->searchable(false)
                ->orderable(false)
                ->width(280),
            Column::make('clicks')
                ->title('Кол-во переходов')
                ->addClass('column-clicks')
                ->width(172),
            Column::make('comment')
                ->title('Комментарий')
                ->addClass('column-comment')
                ->width(172),
            Column::computed('actions')
                ->title('Действия')
                ->addClass('column-actions text-center')
                ->orderable(false)
                ->searchable(false)
                ->width(91),
        ];
    }

    protected function filename(): string
    {
        return 'short_links_'.date('YmdHis');
    }
}
