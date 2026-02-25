<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\CustomTableColumnsDataTable;
use App\DataTables\CustomTableDataDataTable;
use App\DataTables\CustomTablesDataTable;
use App\Models\CustomTable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CustomTablesController extends Controller
{
    public function index(CustomTablesDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('pages.custom-tables.index');
    }

    public function edit(int $custom_table, CustomTableColumnsDataTable $dataTable): View|JsonResponse
    {
        $customTable = CustomTable::findOrFail($custom_table);

        $dataTable->custom_table_id = $custom_table;

        if (request()->ajax()) {
            return $dataTable->ajax();
        }

        return $dataTable->render('pages.custom-tables.edit', ['customTable' => $customTable]);
    }

    public function show(int $custom_table, CustomTableDataDataTable $dataTable): View|JsonResponse
    {
        $customTable = CustomTable::findOrFail($custom_table);

        $dataTable->custom_table_id = $custom_table;

        if (request()->ajax()) {
            return $dataTable->ajax();
        }

        return $dataTable->render('pages.custom-tables.show', ['customTable' => $customTable]);
    }
}
