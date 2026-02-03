<?php

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;

class SettingsController extends Controller
{
    public function index()
    {
        // @TODO: real view
        return view('welcome');
    }

    public function account(AccountsDataTable $dataTable)
    {
        return $dataTable->render('pages.settings.account');
    }
}
