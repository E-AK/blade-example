<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequisitesRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequisitesController extends Controller
{
    public function index(): View
    {
        return view('pages.settings.requisites.index');
    }

    public function store(StoreRequisitesRequest $request): RedirectResponse
    {
        $request->validated();
        // TODO: persist requisites when storage is defined

        return redirect()
            ->route('settings.requisites.index')
            ->with('success', 'Реквизиты сохранены.');
    }
}
