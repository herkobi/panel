<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Settings\Roles;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Role
 */
class RoleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $systemRoles = array_keys(config('panel-permissions.system_roles', []));

        return [
            'uuid' => $this->getKey(),
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'is_system' => in_array($this->name, $systemRoles, true),
            'permissions_count' => $this->whenCounted('permissions'),
            'users_count' => $this->whenCounted('users'),
            'permissions' => $this->whenLoaded('permissions', fn () => $this->permissions->pluck('name')->all()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
