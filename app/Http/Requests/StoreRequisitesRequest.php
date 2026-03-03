<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequisitesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'counterparty_type' => ['required', 'in:legal,individual'],
            'name' => ['required', 'string', 'max:500'],
            'inn' => ['nullable', 'string', 'max:12'],
            'kpp' => ['nullable', 'string', 'max:9'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'counterparty_type.required' => 'Выберите тип контрагента.',
            'counterparty_type.in' => 'Недопустимый тип контрагента.',
            'name.required' => 'Укажите наименование организации.',
        ];
    }
}
