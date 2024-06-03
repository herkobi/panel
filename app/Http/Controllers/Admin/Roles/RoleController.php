<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\Roles\RoleCreateRequest;
use App\Http\Requests\Admin\Roles\Roles\RolePermissionCreateRequest;
use App\Http\Requests\Admin\Roles\Roles\RoleUpdateRequest;
use App\Actions\Admin\Roles\Role\Create;
use App\Actions\Admin\Roles\Role\Update;
use App\Actions\Admin\Roles\Role\Delete;
use App\Actions\Admin\Roles\Role\Detail;
use App\Actions\Admin\Roles\Role\GetAll;
use App\Actions\Admin\Roles\Role\GetOne;
use App\Actions\Admin\Roles\Role\Permissions;
use App\Actions\Admin\Roles\Role\SyncPermissions;
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
    private $detail;
    private $permissions;
    private $syncpermissions;

    public function __construct(
        GetAll $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete,
        Detail $detail,
        Permissions $permissions,
        SyncPermissions $syncpermissions,
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
        $this->detail = $detail;
        $this->permissions = $permissions;
        $this->syncpermissions = $syncpermissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        if (!auth()->user()->can('role.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

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
        if (!auth()->user()->can('role.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

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
        if (!auth()->user()->can('role.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.roles')->with('success', 'Yetki başarılı bir şekilde eklendi.')
                : Redirect::route('panel.roles')->with('error', 'Yetki eklenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        if (!auth()->user()->can('role.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

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
        if (!auth()->user()->can('role.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.roles')->with('success', 'Yetki başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Yetki güncellenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        if (!auth()->user()->can('role.delete')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $role = $this->getOne->execute($id);

        if (!$role) {
            return Redirect::back()->with('error', 'İşleminiz gerçekleştirilemedi.');
        }

        if ($this->isDefault($role)) {
            return Redirect::back()->with('error', 'Seçili yetki kullanıcılar ya da yöneticiler için genel yetki olarak tanımlı. Lütfen önce sistem ayarlarından bu değeri değiştiriniz.');
        }

        if($role->permissions->count() > 0) {
            return Redirect::back()->with('error', 'Yetkiye tanımlı izinler bulunmaktadır. Lütfen önce izinleri kaldırınız.');
        }

        if($role->users()->count() > 0) {
            return Redirect::back()->with('error', 'Yetkiye tanımlı kullanıcılar bulunmaktadır. Lütfen önce tanımları kaldırınız.');
        }

        if($role->name === 'Super Admin') {
            return Redirect::back()->with('error', 'İşleminiz gerçekleştirilemedi.');
        }

        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.roles')->with('success', 'Yetki başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Yetki silinirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions(RolePermissionCreateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('role.sync')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $synced = $this->syncpermissions->execute($id, $request);
        return $synced
                ? Redirect::route('panel.roles')->with('success', __('role.created.permission.success.message'))
                : Redirect::back()->with('error', 'Lütfen en az bir adet izin seçiniz');
    }

    /**
     * Show detail the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id): View
    {
        if (!auth()->user()->can('role.sync')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $role = $this->getOne->execute($id);
        $rolePermissions = $this->detail->execute($role->id);
        $permissions = $this->permissions->execute();
        return view('admin.roles.roles.detail', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ]);
    }

    private function isDefault($role): bool
    {
        return in_array($role->id, [config('panel.userrole'), config('panel.adminrole')]);
    }

}
