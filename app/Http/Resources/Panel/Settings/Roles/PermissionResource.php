<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Settings\Roles;

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
        $registry = config('panel-permissions.permissions');
        $meta = $registry[$this->name] ?? ['group' => 'Diğer', 'label' => $this->name];

        return [
            'uuid' => $this->getKey(),
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'group' => $meta['group'],
            'label' => $meta['label'],
        ];
    }
}
