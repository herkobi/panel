<?php

namespace App\Http\Controllers\User;

use App\Enums\Status;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Usertag;
use App\Utils\PaginateCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $roles = Role::where('type', UserType::USER)->get();
        $users = User::whereNotIn('status', [UserStatus::DELETED])->where('type', [UserType::USER])->get();
        $users = PaginateCollection::paginate($users, 25);
        $tags = Usertag::where('status', [Status::ACTIVE])->has('users')->get();

        return view('users.index', [
            'users' => $users,
            'roles' => $roles,
            'tags' => $tags
        ]);
    }

    /**
     * Kullanıcı Detay Sayfası
     */
    public function show(User $user): View
    {
        $basePermissions = array();
        $permissions = array();
        $tags = Usertag::where('status', Status::ACTIVE)->get();
        $selectedTag = $user->usertags->pluck('id')->toArray();
        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        $rolePermissions = !empty($userCustomPermissions) ? array_merge($rolePermissions, $userCustomPermissions) : $rolePermissions;

        return view('users.detail', [
            'user' => $user,
            'tags' => $tags,
            'selectedTag' => $selectedTag,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function permissions(User $user): View
    {
        $basePermissions = array();
        $permissions = array();
        $rolePermissions = array();

        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', UserType::USER))->get();

        foreach ($permissions as $permission) {
            $basePermissions[$permission->group->name][$permission->id] = [
                'title' => $permission->text,
                'name' => $permission->name
            ];
        }

        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        foreach ($user->roles as $role) {
            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        $rolePermissions = !empty($userCustomPermissions) ? array_merge($rolePermissions, $userCustomPermissions) : $rolePermissions;

        return view('users.permissions', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Kullanıcıları filtreleme
     *
     * Kullanıcılar sayfasındaki ajax filtreleme
     * sonucunun döndüğü kısım
     */
    public function filter(Request $request)
    {
        $users = User::query()->where('type', [UserType::USER]);

        if ($request->has('searchText') && $request->searchText != null) {
            $users->where('name', 'LIKE', "%{$request->searchText}%");
        }

        if ($request->has('statusIds') && $request->statusIds != null) {
            $users->whereIn('status', $request->statusIds);
        }

        if ($request->has('tagIds') && $request->tagIds != null) {
            $users->whereHas('usertags', function ($query) use ($request) {
                $query->whereIn('usertag_id', $request->tagIds);
            });
        }

        if (!$request->has('statusIds') && !$request->has('tagIds') && !$request->has('searchText') && $request->has('page')) {
            $users->paginate('25', ['*'], 'page', $request->page);
            $users = $users->getCollection();
        } else {
            $users = $users->get();
        }

        $users->each(function ($user) {
            $user->roleName = $user->roles->pluck('name')->first();
        });

        return \response()->json($users);
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
