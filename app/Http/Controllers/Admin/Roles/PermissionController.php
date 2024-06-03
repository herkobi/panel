<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Roles\Permission\Create;
use App\Actions\Admin\Roles\Permission\Delete;
use App\Actions\Admin\Roles\Permission\AllPermissions;
use App\Actions\Admin\Roles\Permission\GetOne;
use App\Actions\Admin\Roles\Permission\MainPermissions;
use App\Actions\Admin\Roles\Permission\Update;
use App\Http\Requests\Admin\Roles\Permissions\PermissionCreateRequest;
use App\Http\Requests\Admin\Roles\Permissions\PermissionUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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

    public function index(): View|RedirectResponse
    {
        if (!auth()->user()->can('permission.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

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
    public function create(): View|RedirectResponse
    {
        if (!auth()->user()->can('permission.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

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
        if (!auth()->user()->can('permission.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.permissions')->with('success', 'İzin başarılı bir şekilde eklendi.')
                : Redirect::back()->with('error', 'İzin eklenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View|RedirectResponse
    {
        if (!auth()->user()->can('permission.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $permission = $this->getOne->execute($id);
        $mainPermissions = $this->mainPermissions->execute();
        return view('admin.roles.permissions.edit', [
            'permission' => $permission,
            'mainPermissions' => $mainPermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('permission.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.permissions')->with('success', 'İzin başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'İzin güncellenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        if (!auth()->user()->can('permission.delete')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $permission = $this->getOne->execute($id);

        if (!$permission) {
            return Redirect::back()->with('error', 'İşleminiz gerçekleştirilemedi.');
        }

        if (count($permission->roles) > 0) {
            return Redirect::back()->with('error', 'Lütfen öncelikle izine tanımlı olduğu yetkileri kaldırınız');
        }

        if (count($permission->children) > 0) {
            return Redirect::back()->with('error', 'İzne tanımlı alt izinler bulunmaktadır. Lütfen öncelikle onları kaldırınız.');
        }

        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.permissions')->with('succes', 'İzin başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'İzin silinirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }
}
