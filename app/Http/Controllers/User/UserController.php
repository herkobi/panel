<?php

namespace App\Http\Controllers\User;

use App\Enums\Status;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Usertag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Kullanıcıları listeleme sayfası
     * Durumu silinmiş olmayanlar dışında kalanlar
     * ve türü User olanlar
     */
    public function index(): View
    {
        $tags = Usertag::where('status', [Status::ACTIVE])->get();
        $users = User::whereNotIn('status', [UserStatus::DELETED])->where('type', [UserType::USER])->paginate('25');
        return view('users.index', ['users' => $users, 'tags' => $tags]);
    }

    /**
     * Kullanıcı Detay Sayfası
     */
    public function show(User $user): View
    {
        $tags = Usertag::all();
        $basePermissions = array();
        $permissions = array();
        $selectedTag = $user->usertags->pluck('id')->toArray();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        return view('users.detail', compact('user', 'tags', 'selectedTag', 'basePermissions', 'rolePermissions'));
    }

    public function permissions(User $user): View
    {
        $userRoles = array();
        $basePermissions = array();
        $permissions = array();
        $rolePermissions = array();

        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', UserType::USER))->get();

        foreach ($permissions as $permission) {
            $basePermissions[$permission->group->name][$permission->id] = $permission->text;
        }

        foreach ($user->roles as $role) {
            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        return view('users.permissions', compact('user', 'basePermissions', 'rolePermissions'));
    }

    /**
     * Kullanıcıları filtreleme
     *
     * Kullanıcılar sayfasındaki ajax filtreleme
     * sonucunun döndüğü kısım
     */
    public function filter(Request $request)
    {

        if ($request->has('statusIds')) {
            return response()->json([
                'users' => User::paginate('25'),
            ]);
        }
        //$users = User::where('type', [UserType::USER])->with('usertags')->get();
    }

    /**
     * Kullanıcı durumunu güncelleme
     */
    public function status(Request $request)
    {
        if ($request->ajax() && $request->has('ids')) {
            $user = User::findOrFail($request->user_id);
            foreach (UserStatus::cases() as $userStatus) {
                if ($userStatus->value == $request->ids) {
                    $status = $userStatus->value;
                }
            }

            $user->forceFill([
                'status' => $status
            ])->save();

            return response()->json(['status' => 'success']);
        }
    }


    /**
     * Kullanıcılara etiket atama
     */
    public function tags(Request $request)
    {
        if ($request->ajax() && $request->has('ids')) {
            $user = User::findOrFail($request->user_id);

            $user->usertags()->detach();
            foreach ($request->ids as $tagId) {
                $user->usertags()->attach($tagId);
            }
        }
    }

    /**
     * Kullanıcılar sayfasındaki arama formu
     */
    public function search(Request $request)
    {
        $data = User::select('name', 'email')
            ->where("name", "LIKE", "%{$request->str}%")
            ->oRwhere("email", "LIKE", "%{$request->str}%")
            ->get('query');
        return response()->json($data);
    }
}
