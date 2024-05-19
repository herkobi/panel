<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\Roles\RoleCreateRequest;
use App\Http\Requests\Admin\Roles\Roles\RolePermissionCreateRequest;
use App\Http\Requests\Admin\Roles\Roles\RoleUpdateRequest;
use App\Actions\Admin\Roles\Role\Create;
use App\Actions\Admin\Roles\Role\Update;
use App\Actions\Admin\Roles\Role\Delete;
use App\Actions\Admin\Roles\Role\GetAll;
use App\Actions\Admin\Roles\Role\GetOne;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RoleController extends Controller
{

    private $getAll;
    private $getOne;
    private $create;
    private $update;
    private $delete;

    public function __construct(
        GetAll $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $roles = $this->getAll->execute();
        return view('admin.roles.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.roles.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request): RedirectResponse
    {
        $this->create->execute($request->validated());
        return Redirect::route('panel.roles')->with('success', 'Yetki başarılı bir şekilde eklendi.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $role = $this->getOne->execute($id);
        return view('admin.roles.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id): RedirectResponse
    {
        $this->update->execute($id, $request->validated());
        return Redirect::route('panel.roles')->with('success', 'Yetki başarılı bir şekilde güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $role = $this->getOne->execute($id);

        if (!$role) {
            return Redirect::back()->with('error', 'İşleminiz gerçekleştirilemedi.');
        }

        if ($this->isDefault($role)) {
            return Redirect::back()->with('error', 'Seçili rol kullanıcılar ya da yöneticiler için genel rol olarak tanımlı. Lütfen önce sistem ayarlarından bu değeri değiştiriniz.');
        }

        if($role->permissions->count() > 0) {
            return Redirect::back()->with('error', 'Role tanımlı yetkiler bulunmaktadır. Lütfen önce yetkileri kaldırınız.');
        }

        if($role->users()->count() > 0) {
            return Redirect::back()->with('error', 'Role tanımlı kullanıcılar bulunmaktadır. Lütfen önce kullanıcıları kaldırınız.');
        }

        if($role->name === 'Super Admin') {
            return Redirect::back()->with('error', 'İşleminiz gerçekleştirilemedi.');
        }

        $this->delete->execute($id);
        return Redirect::route('panel.roles')->with('success', 'Yetki başarılı bir şekilde silindi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions(RolePermissionCreateRequest $request, Role $role): RedirectResponse
    {
        if ($request->validated()) {
            $role->syncPermissions($request->permission);

            return Redirect::route('panel.roles')->with('success', __('role.created.permission.success.message'));
        }

        return Redirect::back()->with('Hata; Lütfen en az bir adet izin seçiniz');
    }

    public function detail(Role $role): View
    {
        $permissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        return view('admin.roles.roles.detail', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    private function isDefault($role): bool
    {
        return in_array($role->id, [config('panel.userrole'), config('panel.adminrole')]);
    }

}
