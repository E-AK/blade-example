<?php

declare(strict_types=1);

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;

class BaseDataTable extends DataTable
{
    public function __construct()
    {
        parent::__construct();

        $this->htmlBuilder
            ->parameters([
                'language' => [
                    'search' => 'Поиск',
                    'lengthMenu' => '_MENU_ на странице',
                    'info' => 'с _START_-_END_ из _TOTAL_',
                    'infoEmpty' => '0 из 0',
                    'infoFiltered' => '(отфильтровано из _MAX_)',
                    'zeroRecords' => 'Записи не найдены',
                ],
                'layout' => [
                    'topStart'   => null,
                    'topEnd'     => null,
                    'bottomStart'=> 'paging',
                    'bottomEnd'  => 'pageLength',
                ]
            ]);
    }
}
