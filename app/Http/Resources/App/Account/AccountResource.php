<?php

declare(strict_types=1);

namespace App\Http\Resources\App\Account;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Account
 */
class AccountResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'district_id' => $this->district_id,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
        ];
    }
}
