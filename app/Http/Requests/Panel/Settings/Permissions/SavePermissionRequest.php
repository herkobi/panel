<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\Permissions;

use App\Models\Permission;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Create + update için ortak request. Update sırasında `name` immutable
 * olduğundan rule listesinden çıkarılır.
 */
class SavePermissionRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $permission = $this->route('permission');

        $rules = [
            'group' => ['nullable', 'string', 'max:100'],
            'label' => ['nullable', 'string', 'max:150'],
        ];

        if ($permission === null) {
            $rules['name'] = [
                'required',
                'string',
                'max:150',
                'regex:/^[a-z0-9._-]+$/',
                Rule::unique(Permission::class, 'name')->where('guard_name', 'web'),
            ];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'İzin adı sadece küçük harf, rakam, nokta, tire ve alt çizgi içerebilir.',
        ];
    }
}
