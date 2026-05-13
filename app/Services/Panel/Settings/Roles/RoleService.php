<?php

declare(strict_types=1);

namespace App\Services\Panel\Settings\Roles;

use App\Events\Panel\Settings\Roles\RoleCreatedEvent;
use App\Events\Panel\Settings\Roles\RoleDeletedEvent;
use App\Events\Panel\Settings\Roles\RolePermissionsSyncedEvent;
use App\Events\Panel\Settings\Roles\RoleUpdatedEvent;
use App\Events\Panel\Settings\Roles\UserRoleAssignedEvent;
use App\Events\Panel\Settings\Roles\UserRoleRevokedEvent;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RoleService
{
    /**
     * @param  array{q?: string}  $filters
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = $filters['q'] ?? '';
        $escaped = addcslashes($search, '%_\\');

        return Role::query()
            ->withCount(['permissions', 'users'])
            ->where('name', '!=', 'Super Admin') // Super Admin UI listesinde gizli.
            ->when($search !== '', function ($query) use ($escaped) {
                $query->where('name', 'like', '%'.$escaped.'%');
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();
    }

    /**
     * Süper Admin tüm rolleri atayabilir; sadece `users.create.admin` izni olanlar
     * "Admin" veya "Super Admin" rolü atayabilir.
     *
     * @return Collection<int, Role>
     */
    public function assignableRolesFor(User $causer): Collection
    {
        $all = Role::query()->orderBy('name')->get();

        if ($causer->can('users.create.admin')) {
            return $all;
        }

        $restricted = ['Super Admin', 'Admin'];

        return $all->reject(fn (Role $role): bool => in_array($role->name, $restricted, true))->values();
    }

    /**
     * UI gruplandırması için izinleri grup başlıklarına böl.
     *
     * @return array<string, array<int, array{name: string, label: string}>>
     */
    public function permissionGroups(): array
    {
        $registry = config('panel-permissions.permissions');
        $available = Permission::query()->orderBy('name')->get()->pluck('name')->all();

        // Bu gruplar UI'da izin editörlerinde gösterilmez; sadece seeder Super Admin'e atar.
        $hiddenGroups = ['Özel Yetkiler'];

        $groups = [];
        foreach ($available as $name) {
            $meta = $registry[$name] ?? ['group' => 'Diğer', 'label' => $name];

            if (in_array($meta['group'], $hiddenGroups, true)) {
                continue;
            }

            $groups[$meta['group']][] = [
                'name' => $name,
                'label' => $meta['label'],
            ];
        }

        ksort($groups);

        return $groups;
    }

    /**
     * @param  array{name: string, permissions: array<int, string>}  $data
     */
    public function create(array $data, User $causer): Role
    {
        return DB::transaction(function () use ($data, $causer): Role {
            $role = Role::query()->create([
                'name' => $data['name'],
                'guard_name' => 'web',
            ]);

            $permissions = $this->resolvePermissions($data['permissions']);
            $role->syncPermissions($permissions);

            RoleCreatedEvent::dispatch(
                $role,
                $causer,
                $permissions->pluck('name')->all(),
            );

            return $role;
        });
    }

    /**
     * @param  array{name?: string, permissions?: array<int, string>}  $data
     */
    public function update(Role $role, array $data, User $causer): Role
    {
        return DB::transaction(function () use ($role, $data, $causer): Role {
            $changes = [];

            if (isset($data['name']) && $data['name'] !== $role->name) {
                $changes['name'] = ['from' => $role->name, 'to' => $data['name']];
                $role->forceFill(['name' => $data['name']])->save();
            }

            if (array_key_exists('permissions', $data)) {
                $current = $role->permissions()->pluck('name')->all();
                $next = $data['permissions'];

                $permissions = $this->resolvePermissions($next);
                $role->syncPermissions($permissions);

                $added = array_values(array_diff($next, $current));
                $removed = array_values(array_diff($current, $next));

                if ($added !== [] || $removed !== []) {
                    RolePermissionsSyncedEvent::dispatch($role, $causer, $added, $removed);
                }
            }

            if ($changes !== []) {
                RoleUpdatedEvent::dispatch($role, $causer, $changes);
            }

            return $role;
        });
    }

    public function delete(Role $role, User $causer): void
    {
        if ($this->isSystemRole($role)) {
            throw new RuntimeException(__('Sistem rolleri silinemez.'));
        }

        if ($role->users()->count() > 0) {
            throw new RuntimeException(__('Bu role atanmış kullanıcılar olduğu için silinemiyor.'));
        }

        $name = $role->name;

        DB::transaction(function () use ($role): void {
            $role->delete();
        });

        RoleDeletedEvent::dispatch($name, $causer);
    }

    public function assignToUser(User $user, User $causer, string $roleName): User
    {
        return DB::transaction(function () use ($user, $causer, $roleName): User {
            $previous = $user->roles()->first()?->name;

            $user->syncRoles([$roleName]);

            UserRoleAssignedEvent::dispatch($user, $causer, $roleName, $previous);

            if ($previous !== null && $previous !== $roleName) {
                UserRoleRevokedEvent::dispatch($user, $causer, $previous);
            }

            return $user;
        });
    }

    public function isSystemRole(Role $role): bool
    {
        return in_array($role->name, array_keys(config('panel-permissions.system_roles', [])), true);
    }

    /**
     * @param  array<int, string>  $names
     * @return Collection<int, Permission>
     */
    private function resolvePermissions(array $names): Collection
    {
        if ($names === []) {
            return collect();
        }

        return Permission::query()->whereIn('name', $names)->get();
    }
}
