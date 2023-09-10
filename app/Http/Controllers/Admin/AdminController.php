<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
     * Kullanıcı rolünü güncelleme
     * Ek rol tanımlama
     *
     * @param  array<string, string>  $input
     */
    public function updateRole(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->user);
        foreach ($request->role as $role) {
            $user->assignRole([$role]);
        }

        return Redirect::route('panel.admins');
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

        return response()->json(['status' => "error"]);

    }

    /**
     * Kullanıcıları filtreleme
     *
     * Kullanıcılar sayfasındaki ajax filtreleme
     * sonucunun döndüğü kısım
     */
    public function filter(Request $request)
    {
        $output = '';
        $roles = '';

        //$users = User::query()->where('type', [UserType::USER]);

        $users = User::query()->whereNotIn('status', [UserStatus::DELETED])->where('type', [UserType::USER]);

        if ($request->has('statusIds') && $request->statusIds != null) {
            $users->whereIn('status', $request->statusIds);
        }

        if ($request->has('tagIds') && $request->tagIds != null) {
            $users->whereHas('usertags', function ($query) use ($request) {
                $query->whereIn('usertag_id', $request->tagIds);
            });
        }

        $data = $users->get();
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

                $roles = '';
            }
        } else {
            $output = '<tr><td align="center" colspan="5">Bu isim veya e-mail adresi ile kayıtlı kullanıcı bulunmamaktadır</td></tr>';
        }
        $data = array(
            'table_data'  => $output,
            'total_data'  => $total_row
        );

        echo json_encode($data);

    }

    /**
     * Kullanıcılar sayfasındaki arama formu
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
                $data = User::select('id', 'type', 'status', 'name', 'email')
                    ->where('type', UserType::USER)
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
                $output = '<tr><td align="center" colspan="5">Bu isim veya e-mail adresi ile kayıtlı kullanıcı bulunmamaktadır</td></tr>';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
