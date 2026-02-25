<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\ImportSettingsDataTable;

class ImportSettingsController extends Controller
{
    public function index(ImportSettingsDataTable $dataTable)
    {
        return $dataTable->render('pages.import-settings.index');
    }
}
