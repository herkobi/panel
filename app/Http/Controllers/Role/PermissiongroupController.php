<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionGroups\PermissionGroupCreateRequest;
use App\Http\Requests\PermissionGroups\PermissionGroupUpdateRequest;
use App\Models\Permissiongroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PermissiongroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:permissiongroup-list|permissiongroup-create|permissiongroup-edit|permissiongroup-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:permissiongroup-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permissiongroup-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissiongroup-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $groups = Permissiongroup::paginate('15');
        return view('permissiongroups.index', compact('groups'));
    }

    public function store(PermissionGroupCreateRequest $request)
    {
        if ($request->ajax()) {
            if ($request->validated()) {
                $request = Permissiongroup::create($request->all());
                return response()->json(['status' => "success"]);
            }
        }
    }

    public function edit(Permissiongroup $permissiongroup): View
    {
        return view('permissiongroups.edit', ['permissiongroup' => $permissiongroup]);
    }

    public function update(Permissiongroup $permissiongroup, PermissionGroupUpdateRequest $request): RedirectResponse
    {

        if ($request->validated()) {
            $permissiongroup->forceFill([
                'name' => $request->name,
                'desc' => $request->desc
            ])->save();

            return Redirect::route('panel.permission.groups');
        }

        return Redirect::back();
    }

    public function destroy(Permissiongroup $permissiongroup): RedirectResponse
    {

        if (auth()->user()->roles->pluck('name')[0] ?? '' === 'Super Admin') {
            if (count($permissiongroup->permission) > 0) {
                return Redirect::back()->with('Hata. Bu grup silinemez');
            } else {
                $permissiongroup->delete();
                return Redirect::route('panel.permission.groups');
            }
        }
    }
}
