<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Tools\Definitions;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Language
 */
class LanguageResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'native_name' => $this->native_name,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
