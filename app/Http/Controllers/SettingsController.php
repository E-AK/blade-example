<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;

class SettingsController extends Controller
{
    public function account(AccountsDataTable $dataTable)
    {
        return $dataTable->render('pages.settings.account');
    }
}
