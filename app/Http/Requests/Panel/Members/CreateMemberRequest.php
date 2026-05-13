<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Members;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMemberRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'status' => ['required', 'string', Rule::enum(UserStatus::class)],
            'email_verified' => ['nullable', 'boolean'],
        ];
    }
}
