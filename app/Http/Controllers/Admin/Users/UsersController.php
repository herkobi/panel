<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Users\GetAll;
use App\Actions\Admin\Users\GetUser;
use App\Actions\Admin\Users\GetRoles;
use App\Actions\Admin\Users\Create;
use App\Actions\Admin\Users\Detail\AuthLogs;
use App\Actions\Admin\Users\Detail\UserActivities;
use App\Http\Requests\Admin\Users\UserCreateRequest;
use Illuminate\Http\RedirectResponse;
use App\Mail\NewAdminUserEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UsersController extends Controller
{

    private $getAll;
    private $getUser;
    private $getRoles;
    private $create;
    private $authLogs;
    private $userActivities;

    public function __construct(
        GetAll $getAll,
        GetUser $getUser,
        GetRoles $getRoles,
        Create $create,
        AuthLogs $authLogs,
        UserActivities $userActivities,
    ) {
        $this->getAll = $getAll;
        $this->getUser = $getUser;
        $this->getRoles = $getRoles;
        $this->create = $create;
        $this->authLogs = $authLogs;
        $this->userActivities = $userActivities;
    }

    /**
     * Yöneticileri listeleme sayfası
     */
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->hasRole('Super Admin') || auth()->user()->can('user.management')) {
            $users = $this->getAll->execute();
            return view('admin.users.index', [
                'users' => $users
            ]);
        }

        return Redirect::back()->with('error', __('admin/global.permission.error'));
    }

    /**
     * Yönetici detay sayfası
     */
    public function show($id): View|RedirectResponse
    {

        if (auth()->user()->hasRole('Super Admin') || auth()->user()->can('user.detail')) {
            $user = $this->getUser->execute($id);
            $authLogs = $this->authLogs->execute($id);
            $userActivities = $this->userActivities->execute($id);
            return view('admin.users.detail', [
                'user' => $user,
                'authLogs' => $authLogs,
                'activities' => $userActivities
            ]);
        }

        return Redirect::back()->with('error', __('admin/global.permission.error'));
    }

    /**
     * Yeni yönetici ekleme
     * @param  array<string, string>  $input
     */
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->hasRole('Super Admin') || auth()->user()->can('user.create')) {
            $roles = $this->getRoles->execute();
            return view('admin.users.create', [
                'roles' => $roles
            ]);
        }

        return Redirect::back()->with('error', __('admin/global.permission.error'));
    }

    /**
     * Yönetici ekleme işlemleri.
     *
     * @param  array<string, string>  $input
     */
    public function store(UserCreateRequest $request): RedirectResponse
    {
        if (auth()->user()->hasRole('Super Admin') || !auth()->user()->can('user.create')) {
            $user = $this->create->execute($request->validated());
            foreach ($request->role as $role) {
                $user->assignRole([$role]);
            }

            // Eğer "verifyemail" seçeneği işaretlendiyse, e-posta onayı iste
            if($request->has('verifyemail')) {
                $user->sendEmailVerificationNotification();
            }

            // Eğer "sendemail" seçeneği işaretlendiyse, e-posta gönder
            if ($request->has('sendemail')) {
                Mail::to($user->email)->send(new NewAdminUserEmail($user, $request->password));
            }

            return $user
                    ? Redirect::route('panel.users')->with('success', 'Yönetici başarılı bir şekilde oluşturuldu')
                    : Redirect::back()->with('error', 'Yönetici başarılı bir şekilde oluşturuldu');
        }

        return Redirect::back()->with('error', __('admin/global.permission.error'));
    }

}
