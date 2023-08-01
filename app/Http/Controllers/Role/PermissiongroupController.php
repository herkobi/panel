<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionGroups\PermissionGroupCreateRequest;
use App\Http\Requests\PermissionGroups\PermissionGroupUpdateRequest;
use App\Models\Permissiongroup;
use App\Utils\PaginateCollection;
use Illuminate\Http\JsonResponse;
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
        $groups = Permissiongroup::get();
        $groups = PaginateCollection::paginate($groups, 5);

        return view('permissiongroups.index', compact('groups'));
    }

    public function store(PermissionGroupCreateRequest $request): JsonResponse
    {
        if ($request->ajax() && $request->validated()) {
            $request = Permissiongroup::create($request->all());
            return response()->json(['status' => "success"]);
        }

        return response()->json(['status' => "error"]);

    }

    public function edit(Permissiongroup $permissiongroup): View
    {
        return view('permissiongroups.edit', ['permissiongroup' => $permissiongroup]);
    }

    public function update(Permissiongroup $permissiongroup, PermissionGroupUpdateRequest $request): RedirectResponse
    {
        if ($request->validated()) {
            $permissiongroup->name = $request->name;
            $permissiongroup->desc = $request->desc;
            $permissiongroup->save();

            return Redirect::route('panel.permission.groups')->with('success', 'Yetki grubu başarılı bir şekilde oluşturuldu');
        }

        return Redirect::back()->with('errors', $request->validated()->messages()->all()[0])->withInput();
    }

    public function destroy(Permissiongroup $permissiongroup): RedirectResponse
    {
        if (auth()->user()->roles->pluck('name')[0] ?? '' === 'Super Admin') {
            if (count($permissiongroup->permission) > 0) {
                return Redirect::back()->with('error', 'Yetki grubuna ait izinler bulunmaktadır. Lütfen öncelikle onları siliniz.');
            } else {
                $permissiongroup->delete();
                return Redirect::route('panel.permission.groups')->with('success', 'Yetki grubu başarılı bir şekilde silindi');
            }
        }
        return Redirect::back()->with('error', 'Bu işlemi yapmak için yetkiniz bulunmamaktadır');

    }
}
