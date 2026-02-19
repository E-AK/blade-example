<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;

class SettingsController extends Controller
{
    public function account(AccountsDataTable $dataTable)
    {
        $placeholderUsers = [
            ['name' => 'Марков А.Н.', 'email' => 'alex_markov@company.ru', 'role' => 'Менеджер'],
            ['name' => 'Буров О.Л.', 'email' => 'oleg_burov@company.ru', 'role' => 'Менеджер'],
        ];

        return $dataTable->render('pages.settings.account', [
            'placeholderUsers' => $placeholderUsers,
        ]);
    }
}
