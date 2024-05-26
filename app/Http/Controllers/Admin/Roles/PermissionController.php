<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Actions\Admin\Roles\Permission\Create;
use App\Actions\Admin\Roles\Permission\Delete;
use App\Actions\Admin\Roles\Permission\AllPermissions;
use App\Actions\Admin\Roles\Permission\GetOne;
use App\Actions\Admin\Roles\Permission\MainPermissions;
use App\Actions\Admin\Roles\Permission\Update;
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

    private $allPermissions;
    private $mainPermissions;
    private $getOne;
    private $create;
    private $update;
    private $delete;

    public function __construct(
        AllPermissions $allPermissions,
        MainPermissions $mainPermissions,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete
    ) {
        $this->allPermissions = $allPermissions;
        $this->mainPermissions = $mainPermissions;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function index(): View
    {
        $permissions = $this->allPermissions->execute();
        return view('admin.roles.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $permissions = $this->mainPermissions->execute();
        return view('admin.roles.permissions.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request): RedirectResponse
    {
        $this->create->execute($request->validated());
        return Redirect::route('panel.permissions')->with('success', 'İzin başarılı bir şekilde eklendi.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $permission = $this->getOne->execute($id);
        return view('admin.roles.permissions.edit', [
            'permission' => $permission
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
