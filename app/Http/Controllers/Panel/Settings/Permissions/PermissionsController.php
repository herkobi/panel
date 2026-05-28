<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Settings\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Settings\Permissions\BulkAddPermissionsRequest;
use App\Http\Requests\Panel\Settings\Permissions\SavePermissionRequest;
use App\Models\Permission;
use App\Services\Panel\Settings\Permissions\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PermissionsController extends Controller
{
    public function index(PermissionService $service): Response
    {
        return Inertia::render('panel/settings/permissions/index', [
            'groups' => $service->grouped(),
        ]);
    }

    public function deleted(PermissionService $service): Response
    {
        return Inertia::render('panel/settings/permissions/deleted', [
            'groups' => $service->deletedGrouped(),
        ]);
    }

    public function store(SavePermissionRequest $request, PermissionService $service): RedirectResponse
    {
        $service->create($request->validated(), $request->user());

        return back()->with('toast', ['type' => 'success', 'message' => __('İzin eklendi.')]);
    }

    public function update(SavePermissionRequest $request, Permission $permission, PermissionService $service): RedirectResponse
    {
        $service->update($permission, $request->validated(), $request->user());

        return back()->with('toast', ['type' => 'success', 'message' => __('İzin güncellendi.')]);
    }

    public function destroy(Request $request, Permission $permission, PermissionService $service): RedirectResponse
    {
        $service->delete($permission, $request->user());

        return back()->with('toast', ['type' => 'success', 'message' => __('İzin silindi (geri yüklenebilir).')]);
    }

    public function restore(Request $request, string $permission, PermissionService $service): RedirectResponse
    {
        $model = Permission::onlyTrashed()->where('uuid', $permission)->firstOrFail();

        $service->restore($model, $request->user());

        return back()->with('toast', ['type' => 'success', 'message' => __('İzin geri yüklendi.')]);
    }

    public function forceDelete(Request $request, string $permission, PermissionService $service): RedirectResponse
    {
        $model = Permission::onlyTrashed()->where('uuid', $permission)->firstOrFail();

        $service->forceDelete($model, $request->user());

        return back()->with('toast', ['type' => 'success', 'message' => __('İzin kalıcı olarak silindi.')]);
    }

    public function discover(PermissionService $service): Response
    {
        return Inertia::render('panel/settings/permissions/discover', [
            'routes' => $service->discoverableRoutes()->all(),
        ]);
    }

    public function bulkStore(BulkAddPermissionsRequest $request, PermissionService $service): RedirectResponse
    {
        $count = $service->bulkCreate($request->validated('names'), $request->user());

        return redirect()
            ->route('panel.settings.permissions.index')
            ->with('toast', ['type' => 'success', 'message' => __(':count izin eklendi.', ['count' => $count])]);
    }
}
