<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Profile;

use App\Enums\Status;
use DateTimeZone;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreferencesUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'locale' => [
                'required',
                'string',
                'max:8',
                Rule::exists('languages', 'code')->where(
                    fn ($query) => $query->where('status', Status::Active->value)
                ),
            ],
            'timezone' => [
                'required',
                'string',
                Rule::in(DateTimeZone::listIdentifiers()),
            ],
        ];
    }
}
