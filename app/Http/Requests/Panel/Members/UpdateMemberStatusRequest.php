<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Members;

use App\Enums\UserStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberStatusRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    UserStatus::Active->value,
                    UserStatus::Passive->value,
                ]),
            ],
        ];
    }
}
