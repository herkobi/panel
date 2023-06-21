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
         $this->middleware('permission:permissiongroup-list|permissiongroup-create|permissiongroup-edit|permissiongroup-delete', ['only' => ['index','store']]);
         $this->middleware('permission:permissiongroup-create', ['only' => ['create','store']]);
         $this->middleware('permission:permissiongroup-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permissiongroup-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $groups = Permissiongroup::get();
        return view('permissiongroups.index', compact('groups'));
    }

    public function store(PermissionGroupCreateRequest $request): RedirectResponse
    {

        if($request->validated())
        {
            $request = Permissiongroup::create($request->all());

            notyf()->addSuccess('Grup başarılı bir şekilde kayıt edildi');
            return Redirect::route('panel.permission.groups');
        }

        notyf()->addError('Hata; Bir sorun oluştu lütfen tekrar deneyiniz');
        return Redirect::route('panel.permission.groups');

    }

    public function edit(Permissiongroup $permissiongroup): View
    {
        return view('permissiongroups.edit', ['permissiongroup' => $permissiongroup]);
    }

    public function update(Permissiongroup $permissiongroup, PermissionGroupUpdateRequest $request): RedirectResponse
    {

        if($request->validated()) {
            $permissiongroup->forceFill([
                'name' => $request->name,
                'desc' => $request->desc
            ])->save();

            notyf()->addSuccess('Grup başarılı bir şekilde güncellendi');
            return Redirect::route('panel.permission.groups');
        }

        notyf()->addError('Hata; Bir sorun oluştu şütfen tekrar deneyiniz');
        return Redirect::back();

    }

    public function destroy(Permissiongroup $permissiongroup): RedirectResponse
    {

        if ( auth()->user()->roles->pluck('name')[0] ?? '' === 'Super Admin' )
        {
            if(count($permissiongroup->permission) > 0)
            {
                notyf()->addError('Hata; Gruba ait izinler bulunmaktadır. Lütfen öncelikle izinleri farklı gruplara aktarınız');
                return Redirect::back();
            } else {
                $permissiongroup->delete();

                notyf()->addSuccess('Grup başarılı bir şekilde silindi');
                return Redirect::route('panel.permission.groups');
            }
        }
    }
}
