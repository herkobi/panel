<?php

declare(strict_types=1);

namespace App\Concerns\App\Account;

use Illuminate\Contracts\Validation\ValidationRule;

trait AccountValidationRules
{
    /**
     * Get the validation rules for account settings.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function accountRules(): array
    {
        return [
            'name' => $this->nameRules(),
        ];
    }

    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }
}
