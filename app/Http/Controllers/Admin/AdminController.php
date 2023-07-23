<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    /**
     * Yöneticileri listeleme sayfası
     */
    public function index(): View
    {
        /**
         * Super Admin rolü dışında yöneticiler için tanımlanmış rollere ait kullanıcılar çekiliyor.
         */
        $users = User::where('type', UserType::ADMIN)->get()->except(User::role('Super Admin')->first()->id);
        $roles = Role::where('type', UserType::ADMIN)->get()->except(Role::where('name', 'Super Admin')->first()->id);
        return view('admins.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Yönetici detay sayfası
     */
    public function show(User $user): View
    {
        $basePermissions = array();
        $permissions = array();

        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        $rolePermissions = !empty($userCustomPermissions) ? array_merge($rolePermissions, $userCustomPermissions) : $rolePermissions;

        return view('admins.detail', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function create(): View
    {
        $roles = Role::where([['type', UserType::ADMIN], ['name', '!=', 'Super Admin']])->get();
        return view('admins.create', compact('roles'));
    }

    public function permissions(User $user): View
    {
        $basePermissions = array();
        $permissions = array();
        $rolePermissions = array();

        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', UserType::ADMIN))->get();

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

        return view('admins.permissions', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
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

            $user->status = $status;
            $user->save();

            return response()->json(['status' => "success"]);
        }
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

    /**
     * Yöneticiler sayfasındaki arama formu
     */
    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $roles = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = User::select('id','status', 'name', 'email')
                    ->where('type', UserType::ADMIN)
                    ->where("name", "LIKE", "%{$query}%")
                    ->oRwhere("email", "LIKE", "%{$query}%")
                    ->get('query');
            }

            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    foreach($row->getRoleNames() as $role) {
                        $roles .= '<li><span class="fw-semibold mr-2 mb-2">'.$role.'</span></li>';
                    }

                    $output .= '
                        <tr>
                            <td>
                                <span class="badge fw-normal '.UserStatus::color($row->status).'">'.UserStatus::title($row->status).'</span>
                            </td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->email.'</td>
                            <td>
                                <ul class="list-unstyled list-inline m-0 p-0">'.$roles.'</ul>
                            </td>
                            <td class="text-center">
                            <div class="dropdown">
                                <a class="btn btn-text dropdown-toggle p-0" href="#"
                                    role="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-menu-3-fill"></i>
                                </a>
                                <ul
                                    class="dropdown-menu dropdown-menu-end rounded-0 shadow-none bg-white">
                                    <li><a class="dropdown-item small"
                                            href="'.route('panel.user.detail', $row->id).'">Bilgiler</a>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <button id="addRole" type="button"
                                            class="btn btn-text btn-sm dropdown-item"
                                            value="'.$row->id.'" data-bs-toggle="modal"
                                            data-bs-target="#changeRole">Rol Tanımla</button>
                                    </li>
                                    <li><a class="dropdown-item small"
                                            href="'.route('panel.user.permissions', $row->id).'">Özel
                                            Yetkiler</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>';
                }
            } else {
                $output = '<tr><td align="center" colspan="5">Bu isim veya e-mail adresi ile kayıtlı yönetici bulunmamaktadır</td></tr>';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
