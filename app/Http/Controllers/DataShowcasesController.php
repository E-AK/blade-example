<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\DataShowcasesDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DataShowcasesController extends Controller
{
    public function index(DataShowcasesDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('pages.data-showcases.index');
    }
}
