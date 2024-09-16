<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Actions\Admin\Accounts\Create;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accounts\AccountCreateRequest;
use App\Mail\NewUserEmail;
use App\Services\Admin\Accounts\AccountService;
use App\Services\Admin\Settings\UserService;
use App\Services\Admin\Tools\AuthLogsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AccountsController extends Controller
{
    protected $userService;
    protected $accountService;
    protected $authLogs;
    protected $createUser;


    public function __construct(
        UserService $userService,
        AuthLogsService $authLogs,
        AccountService $accountService,
        Create $createUser,
    ) {
        $this->userService = $userService;
        $this->accountService = $accountService;
        $this->authLogs = $authLogs;
        $this->createUser = $createUser;
    }

    public function index(): View
    {
        $users = $this->userService->getAccounts();
        return view('admin.accounts.index', [
            'users' => $users
        ]);
    }

    public function detail(string $id): View
    {
        $user = $this->userService->getUserById($id);
        $activities = $this->userService->getUserActivity($id);
        return view('admin.accounts.detail', [
            'user' => $user,
            'activities' => $activities
        ]);
    }

    public function authlogs(string $id): View
    {
        $user = $this->userService->getUserById($id);
        $logs = $this->authLogs->userAuthLogs($user->id);
        return view('admin.accounts.authlogs', [
            'user' => $user,
            'logs' => $logs
        ]);
    }

    public function create(): View
    {
        return view('admin.accounts.create');
    }

    public function store(AccountCreateRequest $request): RedirectResponse
    {
        $created = $this->createUser->execute($request->validated());

        if($request->has('verifyemail')) {
            $created->sendEmailVerificationNotification();
        }

        if ($request->has('sendemail')) {
            Mail::to($created->email)->send(new NewUserEmail($created, $request->password));
        }

        return $created
                ? Redirect::route('panel.accounts')->with('success', 'Yeni kullanıcı başarılı bir şekilde oluşturuldu')
                : Redirect::back()->with('error', 'Yeni kullanıcı oluşturulurken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    public function latest(): View
    {
        $users = $this->accountService->getLastThirtyDaysActiveMembers();
        return view('admin.accounts.latest', [
            'users' => $users
        ]);
    }

    public function unverified(): View
    {
        $users = $this->accountService->getUnverifiedActiveUsers();
        return view('admin.accounts.unverified', [
            'users' => $users
        ]);
    }

    public function inactive(): View
    {
        $users = $this->accountService->getInactiveActiveUsers();
        return view('admin.accounts.inactive', [
            'users' => $users
        ]);
    }

    public function draft(): View
    {
        $users = $this->accountService->getDraftUsers();
        return view('admin.accounts.draft', [
            'users' => $users
        ]);
    }

    public function passive(): View
    {
        $users = $this->accountService->getPassiveUsers();
        return view('admin.accounts.passive', [
            'users' => $users
        ]);
    }

    public function deleted(): View
    {
        $users = $this->accountService->getDeletedUsers();
        return view('admin.accounts.deleted', [
            'users' => $users
        ]);
    }
}
