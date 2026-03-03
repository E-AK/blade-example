<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChangePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    public function index(): View
    {
        return view('pages.settings.change-password.index');
    }

    public function store(StoreChangePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->password = Hash::make($request->validated('password'));
        $user->save();

        return redirect()
            ->route('settings.change-password.index')
            ->with('success', 'Пароль успешно изменён.');
    }
}
