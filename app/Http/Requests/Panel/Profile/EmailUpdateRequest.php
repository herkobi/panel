<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Profile;

use App\Concerns\Panel\Profile\ProfileValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailUpdateRequest extends FormRequest
{
    use ProfileValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                ...$this->emailRules($this->user()->id),
                Rule::notIn([(string) $this->user()->email]),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.not_in' => 'Yeni e-posta adresi mevcut e-posta adresinizden farklı olmalıdır.',
        ];
    }
}
