<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuestAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:guest_accounts,email'],
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'comment' => ['nullable', 'string', 'max:500'],
            'connections' => ['boolean'],
            'data_collection' => ['boolean'],
            'custom_tables' => ['boolean'],
            'services' => ['boolean'],
            'event_chains' => ['boolean'],
            'reports' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Укажите имя.',
            'email.required' => 'Укажите email.',
            'email.email' => 'Укажите корректный email.',
            'email.unique' => 'Гостевой аккаунт с таким email уже существует.',
        ];
    }
}
