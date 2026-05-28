<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\Permissions;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BulkAddPermissionsRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'names' => ['required', 'array', 'min:1'],
            'names.*' => ['required', 'string', 'max:150', 'regex:/^[a-z0-9._-]+$/'],
        ];
    }
}
