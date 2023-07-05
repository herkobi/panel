<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\PermissionCreateRequest;
use App\Http\Requests\Permissions\PermissionUpdateRequest;
use App\Models\Permission;
use App\Models\Permissiongroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        $groups = Permissiongroup::get();
        return view('permissions.index', compact(['permissions', 'groups']));
    }

    public function store(PermissionCreateRequest $request): JsonResponse
    {
        if ($request->ajax() && $request->validated()) {

            Permission::create($request->all());

            // $group_id = $request->group_id;
            // $attr = array_combine($request->name, $request->text);
            // $guard = 'web';

            // foreach ($attr as $key => $req) {
            //    Permission::create(['name' => $key, 'group_id' => $group_id, 'text' => $req, 'guard_name' => $guard]);
            // }

            return response()->json(['status' => "success"]);
        }
    }

    public function edit(Permission $permission): View
    {
        $groups = Permissiongroup::get();
        return view('permissions.edit', ['permission' => $permission, 'groups' => $groups]);
    }

    public function update(PermissionUpdateRequest $request, Permission $permission): RedirectResponse
    {
        if ($request->validated()) {
            $permission->forceFill([
                'group_id' => $request->group_id,
                'name' => $request->name,
                'text' => $request->text
            ])->save();

            return Redirect::route('panel.permissions');
        }

        return Redirect::back();
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
