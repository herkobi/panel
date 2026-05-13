<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Tools\Definitions;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveDistrictRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $city = $this->route('city');

        if ($city !== null && isset($city->id)) {
            $this->merge(['city_id' => $city->id]);
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
        return [
            'city_id' => ['required', 'uuid', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => [Rule::enum(Status::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
