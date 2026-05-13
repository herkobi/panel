<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Tools\Definitions;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SaveCountryRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $name = $this->string('name')->toString();

        if ($name !== '') {
            $this->merge(['slug' => Str::slug($name)]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $countryId = $this->route('country')?->id;

        return [
            'code' => [
                'required', 'string', 'size:2',
                Rule::unique('countries', 'code')->ignore($countryId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255',
                Rule::unique('countries', 'slug')->ignore($countryId),
            ],
            'status' => [Rule::enum(Status::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
