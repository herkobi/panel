<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Tools\Definitions;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin District
 */
class DistrictResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city_id' => $this->city_id,
            'name' => $this->name,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
