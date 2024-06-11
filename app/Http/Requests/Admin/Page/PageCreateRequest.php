<?php

namespace App\Http\Requests\Admin\Page;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PageCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'integer', new Enum(Status::class)],
            'title' => ['required', 'string', 'max:255', Rule::unique('pages', 'title')],
            'text' => ['required']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

            /**
             * Status Messages
             */
            'status.required' => __('admin/pages/request.status.required'),
            'status.integer' => __('admin/pages/request.status.integer'),

            /**
             * Title Messages
             */
            'title.required' => __('admin/pages/request.title.required'),
            'title.string' => __('admin/pages/request.title.string'),
            'title.max' => __('admin/pages/request.title.max'),
            'title.unique' => __('admin/pages/request.title.unique'),

            /**
             * Desc Messages
             */
            'text.required' => __('admin/pages/request.text.required'),

        ];
    }
}
