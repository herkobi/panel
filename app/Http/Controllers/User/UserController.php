<?php

namespace App\Http\Controllers\User;

use App\Enums\Status;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Permissiongroup;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Usertag;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verifyEmail');
    }

    public function index(): View
    {
        $tags = Usertag::where('status', [Status::ACTIVE])->get();
        $users = User::whereNotIn('status', [UserStatus::DELETED])->where('type', [UserType::USER])->get();
        return view('users.index', ['users' => $users, 'tags' => $tags]);
    }

    public function show(User $user): View
    {
        $tags = Usertag::all();
        $usertags = $user->usertags;
        $basePermissions = array();
        $permissions = array();
        $selectedTag = $user->usertags->pluck('id')->toArray();

        // foreach ($usertags as $tag) {
        //     $selectedTag = $tag->id;
        // }

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
                'users' => User::take(5)->get(),
            ]);
        }
        //$users = User::where('type', [UserType::USER])->with('usertags')->get();
    }

    public function tags(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('tagIds')) {
                $user = User::find($request->user_id);
                if ($user->usertags->count() > 0) {
                    $user->usertags()->syncWithoutDetaching($request->tagIds);
                } else {
                    $user->usertags()->sync($request->tagIds, false);
                }
            }
        }
    }
}
