<?php

declare(strict_types=1);

namespace App\Http\Requests\App\Account;

use App\Enums\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'postal_code' => ['nullable', 'string', 'max:16'],
            'country_id' => [
                'nullable',
                'required_with:city_id,district_id',
                'uuid',
                Rule::exists('countries', 'id')->where('status', Status::Active->value),
            ],
            'city_id' => [
                'nullable',
                'required_with:district_id',
                'uuid',
                Rule::exists('cities', 'id')
                    ->where('country_id', $this->string('country_id')->toString())
                    ->where('status', Status::Active->value),
            ],
            'district_id' => [
                'nullable',
                'uuid',
                Rule::exists('districts', 'id')
                    ->where('city_id', $this->string('city_id')->toString())
                    ->where('status', Status::Active->value),
            ],
        ];
    }
}
