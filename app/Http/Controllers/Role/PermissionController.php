<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\PermissionCreateRequest;
use App\Http\Requests\Permissions\PermissionUpdateRequest;
use App\Models\Permission;
use App\Models\Permissiongroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Alert;
use App\Utils\PaginateCollection;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $permissions = Permission::get();
        $permissions = PaginateCollection::paginate($permissions, 5);

        $groups = Permissiongroup::get();
        return view('permissions.index', [
            'permissions' => $permissions,
            'groups' => $groups
        ]);
    }

    public function store(PermissionCreateRequest $request): RedirectResponse
    {
        $guard_name = "web";

        if ($request->validated()) {
            $permission = Permission::create([
                'name' => $request['name'],
                'group_id' => $request['group_id'],
                'text' => $request['text'],
                'guard_name' => $guard_name
            ]);

            return Redirect::route('panel.permissions')->with('success', 'İzin başarılı bir şekilde oluşturuldu');
        }

        return Redirect::back()->with('errors', $request->validated()->messages()->all()[0])->withInput();

    }

    public function edit(Permission $permission): View
    {
        $groups = Permissiongroup::get();
        return view('permissions.edit', ['permission' => $permission, 'groups' => $groups]);
    }

    public function update(PermissionUpdateRequest $request, Permission $permission): RedirectResponse
    {
        if ($request->validated()) {
            $permission->group_id = $request->group_id;
            $permission->name = $request->name;
            $permission->text = $request->text;
            $permission->save();

            return Redirect::route('panel.permissions')->with('Success', 'İzin başarılı bir şekilde güncellendi');
        }

        return Redirect::back()->with('Error', 'Güncelleme yapılırken bir sorun oluştu. Lütfen tekrar deneyiniz');
    }

    public function destroy(Permission $permission): RedirectResponse
    {

        if (Auth::user()->roles->first()->name === 'Super Admin') {
            if (count($permission->roles) > 0) {
                return Redirect::back();
            } else {
                $permission->delete();

                return Redirect::route('panel.permissions');
            }
        }
    }
}
