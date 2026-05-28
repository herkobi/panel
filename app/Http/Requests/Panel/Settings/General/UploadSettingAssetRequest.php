<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\General;

use App\Services\Panel\Settings\General\SettingsService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadSettingAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // Favicon küçük olmalı (max 512 KB); logo'lar 2 MB'a kadar.
        $max = $this->input('key') === 'favicon_path' ? 512 : 2048;

        return [
            'key' => ['required', 'string', Rule::in(array_keys(SettingsService::FILE_KEYS))],
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png', "max:{$max}"],
        ];
    }
}
