<?php

declare(strict_types=1);

namespace App\Http\Controllers\Connections;

use App\DataTables\SbisDataTable;
use App\Http\Controllers\Controller;

class SbisController extends Controller
{
    public function index(SbisDataTable $dataTable)
    {
        return $dataTable->render('pages.connections.sbis');
    }
}
