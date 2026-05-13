<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\Roles;

use App\Models\User;
use App\Services\Panel\Settings\Roles\RoleService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignUserRoleRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $causer */
        $causer = $this->user();

        $assignable = app(RoleService::class)
            ->assignableRolesFor($causer)
            ->pluck('name')
            ->all();

        return [
            'role' => [
                'required',
                'string',
                Rule::in($assignable),
            ],
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
