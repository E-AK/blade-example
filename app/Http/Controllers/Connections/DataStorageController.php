<?php

declare(strict_types=1);

namespace App\Http\Controllers\Connections;

use App\DataTables\DataStoragesDataTable;
use App\Http\Controllers\Controller;

class DataStorageController extends Controller
{
    public function index(DataStoragesDataTable $dataTable)
    {
        return $dataTable->render('pages.connections.data-storage');
    }
}
