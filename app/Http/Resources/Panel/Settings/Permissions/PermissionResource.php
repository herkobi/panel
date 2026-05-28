<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Settings\Permissions;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Permission
 */
class PermissionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->getKey(),
            'name' => $this->name,
            'group' => $this->group,
            'label' => $this->label,
            'roles_count' => $this->whenCounted('roles'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
