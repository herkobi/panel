<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Tools\Definitions;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveLanguageRequest extends FormRequest
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
        $languageId = $this->route('language')?->id;

        return [
            'code' => [
                'required', 'string', 'min:2', 'max:5',
                Rule::unique('languages', 'code')->ignore($languageId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'native_name' => ['required', 'string', 'max:255'],
            'status' => [Rule::enum(Status::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
