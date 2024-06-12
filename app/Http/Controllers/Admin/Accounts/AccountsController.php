<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Accounts\GetAccounts;
use App\Actions\Admin\Accounts\GetAccount;
use App\Actions\Admin\Accounts\GetRoles;
use App\Actions\Admin\Accounts\Create;
use App\Actions\Admin\Accounts\Detail\AuthLogs;
use App\Actions\Admin\Accounts\Detail\UserActivities;
use App\Http\Requests\Admin\Accounts\AccountCreateRequest;
use Illuminate\Http\RedirectResponse;
use App\Mail\NewAdminUserEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AccountsController extends Controller
{

    private $getAccounts;
    private $getAccount;
    private $getRoles;
    private $create;
    private $authLogs;
    private $userActivities;

    public function __construct(
        GetAccounts $getAccounts,
        GetAccount $getAccount,
        GetRoles $getRoles,
        Create $create,
        AuthLogs $authLogs,
        UserActivities $userActivities,
    ) {
        $this->getAccounts = $getAccounts;
        $this->getAccount = $getAccount;
        $this->getRoles = $getRoles;
        $this->create = $create;
        $this->authLogs = $authLogs;
        $this->userActivities = $userActivities;
    }

    public function index(): View|RedirectResponse
    {
        if (!auth()->user()->can('account.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $users = $this->getAccounts->execute();
        return view('admin.accounts.index', [
            'users' => $users
        ]);
    }

    /**
     * Hesap detay sayfası
     */
    public function show($id): View|RedirectResponse
    {
        if (!auth()->user()->can('account.detail')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $user = $this->getAccount->execute($id);
        $authLogs = $this->authLogs->execute($id);
        $userActivities = $this->userActivities->execute($id);
        return view('admin.accounts.detail', [
            'user' => $user,
            'authLogs' => $authLogs,
            'activities' => $userActivities
        ]);
    }

    /**
     * Yeni hesap ekleme
     * @param  array<string, string>  $input
     */
    public function create(): View|RedirectResponse
    {
        if (!auth()->user()->can('account.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $roles = $this->getRoles->execute();
        return view('admin.accounts.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Yönetici ekleme işlemleri.
     *
     * @param  array<string, string>  $input
     */
    public function store(AccountCreateRequest $request): RedirectResponse
    {
        if (!auth()->user()->can('account.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

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
                ? Redirect::route('panel.accounts')->with('success', __('admin/accounts/create.store.success'))
                : Redirect::back()->with('error', __('admin/accounts/create.store.error'));
    }

}
