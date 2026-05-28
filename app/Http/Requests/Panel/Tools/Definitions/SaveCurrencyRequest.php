<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Tools\Definitions;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCurrencyRequest extends FormRequest
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
        $currencyId = $this->route('currency')?->id;

        return [
            'code' => [
                'required', 'string', 'size:3',
                Rule::unique('currencies', 'code')->ignore($currencyId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'symbol' => ['required', 'string', 'max:8'],
            'decimal_places' => ['required', 'integer', 'min:0', 'max:6'],
            'thousands_separator' => ['required', 'string', 'size:1'],
            'decimal_separator' => ['required', 'string', 'size:1', 'different:thousands_separator'],
            'status' => [Rule::enum(Status::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
