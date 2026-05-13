<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Settings\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Settings\Roles\CreateRoleRequest;
use App\Http\Requests\Panel\Settings\Roles\UpdateRoleRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Settings\Roles\RoleResource;
use App\Models\Role;
use App\Models\User;
use App\Services\Panel\Settings\Roles\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class RolesController extends Controller
{
    public function index(Request $request, RoleService $service): Response
    {
        $filters = [
            'q' => $request->string('q')->toString(),
        ];

        return Inertia::render('panel/settings/roles/index', [
            'roles' => PaginatedResource::make($service->paginate($filters), RoleResource::class, $request),
            'filters' => $filters,
        ]);
    }

    public function create(RoleService $service): Response
    {
        return Inertia::render('panel/settings/roles/create', [
            'permissionGroups' => $service->permissionGroups(),
        ]);
    }

    public function store(CreateRoleRequest $request, RoleService $service): RedirectResponse
    {
        /** @var User $causer */
        $causer = $request->user();

        $role = $service->create([
            'name' => (string) $request->validated('name'),
            'permissions' => (array) $request->validated('permissions', []),
        ], $causer);

        return to_route('panel.settings.roles.show', $role)
            ->with('toast', [
                'type' => 'success',
                'message' => __('Rol oluşturuldu.'),
            ]);
    }

    public function show(Role $role, RoleService $service): Response
    {
        $role->loadCount('users')->load('permissions');

        return Inertia::render('panel/settings/roles/show', [
            'role' => RoleResource::make($role),
            'permissionGroups' => $service->permissionGroups(),
            'isSystem' => $service->isSystemRole($role),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role, RoleService $service): RedirectResponse
    {
        /** @var User $causer */
        $causer = $request->user();

        $service->update($role, [
            'name' => (string) $request->validated('name'),
            'permissions' => (array) $request->validated('permissions', []),
        ], $causer);

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Rol güncellendi.'),
        ]);
    }

    public function destroy(Request $request, Role $role, RoleService $service): RedirectResponse
    {
        /** @var User $causer */
        $causer = $request->user();

        try {
            $service->delete($role, $causer);
        } catch (RuntimeException $exception) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }

        return to_route('panel.settings.roles.index')
            ->with('toast', [
                'type' => 'success',
                'message' => __('Rol silindi.'),
            ]);
    }
}
