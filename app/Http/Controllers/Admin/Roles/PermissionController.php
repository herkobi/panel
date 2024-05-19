<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\Permissions\PermissionCreateRequest;
use App\Http\Requests\Admin\Roles\Permissions\PermissionUpdateRequest;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Utils\PaginateCollection;

class PermissionController extends Controller
{

    public function index(): View
    {
        $permissions = Permission::get();
        $permissions = PaginateCollection::paginate($permissions, 5);
        return view('admin.roles.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    public function store(PermissionCreateRequest $request): RedirectResponse
    {
        $guard_name = "web";

        $permission = Permission::create([
            'name' => $request['name'],
            'text' => $request['text'],
            'guard_name' => $guard_name
        ]);

        if ($permission) {
            return Redirect::route('panel.permissions')->with('success', 'İzin başarılı bir şekilde oluşturuldu');
        }

        return Redirect::back()->with('errors', $request->validated()->messages()->all()[0])->withInput();

    }

    public function edit(Permission $permission): View
    {
        return view('admin.roles.permissions.edit', [
            'permission' => $permission,
        ]);
    }

    public function update(PermissionUpdateRequest $request, Permission $permission): RedirectResponse
    {
        $permission = $permission->update([
            'group_id' => $request->group_id,
            'name' => $request->name,
            'text' => $request->text
        ]);

        if ($permission) {
            return Redirect::route('panel.permissions')->with('success', 'İzin başarılı bir şekilde güncellendi');
        }

        return Redirect::back()->with('error', 'Güncelleme yapılırken bir sorun oluştu. Lütfen tekrar deneyiniz');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission = Permission::findOrFail($permission->id);

        if (Auth::user()->roles->first()->name === 'Super Admin') {
            if (count($permission->roles) > 0) {
                return Redirect::back()->with('info', 'Lütfen öncelikle izine tanımlı yetkileri kaldırınız');
            } else {
                $permission->delete();
                return Redirect::route('panel.permissions')->with('succes', 'İzin başarılı bir şekilde silindi');
            }
        }
    }
}
