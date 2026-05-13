<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Tools\Cache;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClearCacheRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $type = $this->route('type');

        if (is_string($type)) {
            $this->merge(['type' => $type]);
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
            'type' => ['required', Rule::in(['application', 'config', 'route', 'view', 'event', 'compiled', 'all'])],
        ];
    }
}
