<?php

declare(strict_types=1);

namespace App\Http\Controllers\Connections;

use App\Http\Controllers\Controller;

class SbisController extends Controller
{
    public function index()
    {
        return view('pages.connections.sbis');
    }
}
