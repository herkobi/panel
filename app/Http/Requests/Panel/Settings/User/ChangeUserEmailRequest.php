<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\User;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeUserEmailRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User|null $user */
        $user = $this->route('user');

        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user?->id),
                Rule::notIn([(string) $user?->email]),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.not_in' => 'Yeni e-posta adresi mevcut e-posta adresinden farklı olmalıdır.',
        ];
    }
}
