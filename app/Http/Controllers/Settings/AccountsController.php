<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\DataTables\AccountsDataTable;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function index(AccountsDataTable $dataTable)
    {
        $placeholderUsers = [
            ['name' => 'Марков А.Н.', 'email' => 'alex_markov@company.ru', 'role' => 'Менеджер'],
            ['name' => 'Буров О.Л.', 'email' => 'oleg_burov@company.ru', 'role' => 'Менеджер'],
        ];

        return $dataTable->withoutActiveColumn()->render('pages.settings.account', [
            'placeholderUsers' => $placeholderUsers,
        ]);
    }
}
