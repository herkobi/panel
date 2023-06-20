<?php

namespace App\Http\Controllers\Role;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\RoleCreateRequest;
use App\Http\Requests\Roles\RolePermissionCreateRequest;
use App\Http\Requests\Roles\RoleUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Permissiongroup;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $roles = Role::all()->except(Role::where('name', 'Super Admin')->first()->id);
        $baseRoutes = array();

        foreach ($roles as $key => $role) {
            if ($role->permissions->count() > 0) {

                foreach ($role->permissions as $permission) {
                    $baseRoutes[$role->name]["roleId"] = $role->id;
                    $baseRoutes[$role->name]["roleType"] = $role->type;
                    $baseRoutes[$role->name]["permissions"][$permission->group->name][] = $permission->text;
                }
            } else {
                $baseRoutes[$role->name]["roleId"] = $role->id;
                $baseRoutes[$role->name]["roleType"] = $role->type;
            }
        }

        return view('roles.index', compact('baseRoutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        activity()->log(Auth::user()->name . ' yeni yetki oluşturmak için yetki formu sayfasını açtı');
        return view('roles.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions(RoleCreateRequest $request): RedirectResponse
    {

        activity()->log(Auth::user()->name . ' yeni yetki oluşturdu. İzinler sayfasına geçti.');

        if ($request->validated()) {
            $role = Role::create(['name' => $request->name, 'type' => $request->type, 'desc' => $request->desc]);
            return Redirect::route('panel.role.permissions.store', $role);
        } else {
            notyf()->addError('Hata; Lütfen tüm gerekli alanları doldurunuz');
            return Redirect::back();
        }
    }

    public function permissionsstore(Role $role): View
    {
        $role = Role::find($role->id);
        $groups = Permissiongroup::where('type', $role->type)->with('permission')->get();
        activity()->log(Auth::user()->name . ' oluşturduğu yetki için izinler oluşturdu');
        return view('roles.permissions', ['role' => $role, 'groups' => $groups]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolePermissionCreateRequest $request, Role $role): RedirectResponse
    {

        if ($request->validated()) {
            $role->syncPermissions($request->permission);
            activity()->log(Auth::user()->name . ' oluşturduğu yetki için izinleri ayarladı');
            notyf()->addSuccess('Yetki başarılı bir şekilde kayıt edildi');
            return Redirect::route('panel.roles');
        }

        return Redirect::back()->with('Hata; Lütfen en az bir adet izin seçiniz');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role): View
    {
        $role = Role::find($role->id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        activity()->log(Auth::user()->name . '; ' . $role->name . ' yetkisini görüntüledi');
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role): View
    {
        $role = Role::find($role->id);
        if ($role->name != 'Super Admin') {
            $basePermissions = array();
            $permissions = array();
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();

            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();

            return view('roles.edit', compact('role', 'basePermissions', 'rolePermissions'));
        } else {
            return Redirect::back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        $role->name = $request->name;
        $role->desc = $request->desc;
        $role->save();

        $role->syncPermissions($request->input('permission'));

        notyf()->addSuccess('Yetki başarılı bir şekilde güncellendi');
        return Redirect::route('panel.roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (auth()->user()->roles->pluck('name')[0] ?? '' === 'Super Admin' || auth()->user->is_super == '1') {
            DB::table("roles")->where('id', $role->id)->delete();

            notyf()->addSuccess('Yetki başarılı bir şekilde silindi');
            return Redirect::route('panel.roles');
        }
    }
}
