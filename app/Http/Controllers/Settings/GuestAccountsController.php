<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\DataTables\GuestAccountsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuestAccountRequest;
use App\Models\GuestAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class GuestAccountsController extends Controller
{
    public function index(GuestAccountsDataTable $dataTable)
    {
        return $dataTable->render('pages.settings.guest-accounts.index');
    }

    public function store(StoreGuestAccountRequest $request)
    {
        $data = $request->validated();
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['connections'] = $request->boolean('connections');
        $data['data_collection'] = $request->boolean('data_collection');
        $data['custom_tables'] = $request->boolean('custom_tables');
        $data['services'] = $request->boolean('services');
        $data['event_chains'] = $request->boolean('event_chains');
        $data['reports'] = $request->boolean('reports');
        GuestAccount::query()->create($data);

        return redirect()
            ->route('settings.guest-accounts.index')
            ->with('success', 'Гостевой аккаунт создан.');
    }
}
