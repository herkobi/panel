<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\User;

use App\Enums\UserStatus;
use App\Models\User;
use App\Services\Panel\Settings\Roles\RoleService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $causer */
        $causer = $this->user();

        $assignableRoles = app(RoleService::class)
            ->assignableRolesFor($causer)
            ->pluck('name')
            ->all();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'status' => ['required', 'string', Rule::enum(UserStatus::class)],
            'role' => ['required', 'string', Rule::in($assignableRoles)],
            'email_verified' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'role.in' => 'Bu rolü atama yetkiniz yok.',
        ];
    }
}
