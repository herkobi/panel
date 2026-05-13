<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Tools\Definitions;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin City
 */
class CityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'code' => $this->code,
            'name' => $this->name,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
