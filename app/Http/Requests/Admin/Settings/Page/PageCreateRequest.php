<?php

namespace App\Http\Requests\Admin\Settings\Page;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;

class PageCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(Status::class)],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }
}
