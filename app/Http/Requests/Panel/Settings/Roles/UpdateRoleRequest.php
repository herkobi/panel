<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\Roles;

use App\Models\Role;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Role|null $role */
        $role = $this->route('role');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Role::class, 'name')
                    ->where('guard_name', 'web')
                    ->ignore($role?->getKey(), $role?->getKeyName()),
            ],
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }
}
