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
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(): View
    {
        $tags = Usertag::where('status', [Status::ACTIVE])->get();
        $users = User::whereNotIn('status', [UserStatus::DELETED])->where('type', [UserType::USER])->paginate('25');
        return view('users.index', ['users' => $users, 'tags' => $tags]);
    }

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

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function filter(Request $request)
    {

        if ($request->has('statusIds')) {
            return response()->json([
                'users' => User::paginate('25'),
            ]);
        }
        //$users = User::where('type', [UserType::USER])->with('usertags')->get();
    }

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
        }
    }

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
}
