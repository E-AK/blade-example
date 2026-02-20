<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;

class AccountsController extends Controller
{
    public function index(AccountsDataTable $dataTable)
    {
        return $dataTable->render('pages.account');
    }
}
