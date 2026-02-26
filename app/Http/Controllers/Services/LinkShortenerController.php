<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\DataTables\ShortLinksDataTable;
use App\Http\Controllers\Controller;

class LinkShortenerController extends Controller
{
    public function index(ShortLinksDataTable $dataTable)
    {
        return $dataTable->render('pages.services.link-shortener');
    }
}
