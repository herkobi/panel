<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Tools\Definitions;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCityRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $country = $this->route('country');

        if ($country !== null && isset($country->id)) {
            $this->merge(['country_id' => $country->id]);
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
        $cityId = $this->route('city')?->id;
        $countryId = $this->string('country_id')->toString();

        return [
            'country_id' => ['required', 'uuid', 'exists:countries,id'],
            'code' => [
                'required', 'string', 'max:16',
                Rule::unique('cities', 'code')
                    ->ignore($cityId)
                    ->where(fn ($q) => $q->where('country_id', $countryId)),
            ],
            'name' => ['required', 'string', 'max:255'],
            'status' => [Rule::enum(Status::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
