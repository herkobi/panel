<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Actions\Admin\Accounts\Create;
use App\Actions\Admin\Accounts\ChangeEmail;
use App\Actions\Admin\Accounts\CheckEmail;
use App\Actions\Admin\Accounts\ResetPassword;
use App\Actions\Admin\Accounts\StatusUpdate;
use App\Actions\Admin\Accounts\VerifyEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accounts\AccountCreateRequest;
use App\Http\Requests\Admin\Accounts\ChangeEmailRequest;
use App\Http\Requests\Admin\Accounts\CheckEmailRequest;
use App\Http\Requests\Admin\Accounts\ResetPasswordRequest;
use App\Http\Requests\Admin\Accounts\StatusUpdateRequest;
use App\Http\Requests\Admin\Accounts\VerifyEmailRequest;
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
    protected $statusUpdate;
    protected $changeEmail;
    protected $verifyEmail;
    protected $checkEmail;
    protected $resetPassword;

    public function __construct(
        UserService $userService,
        AuthLogsService $authLogs,
        AccountService $accountService,
        Create $createUser,
        StatusUpdate $statusUpdate,
        ChangeEmail $changeEmail,
        VerifyEmail $verifyEmail,
        CheckEmail $checkEmail,
        ResetPassword $resetPassword,
    ) {
        $this->userService = $userService;
        $this->accountService = $accountService;
        $this->authLogs = $authLogs;
        $this->createUser = $createUser;
        $this->statusUpdate = $statusUpdate;
        $this->changeEmail = $changeEmail;
        $this->verifyEmail = $verifyEmail;
        $this->checkEmail = $checkEmail;
        $this->resetPassword = $resetPassword;
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
        $user = $this->userService->getUserActivity($id);
        return view('admin.accounts.detail', [
            'user' => $user,
            'activities' => $user->activities
        ]);
    }

    public function authlogs(string $id): View
    {
        $user = $this->userService->getUserAuthLogs($id);
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

    public function statusUpdate(StatusUpdateRequest $request, $id): RedirectResponse
    {
        $updated = $this->statusUpdate->execute($id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'Kullanıcı durumu başarılı bir şekilde güncellendi.')
            : Redirect::back()->with('error', 'Hata; Lütfen geçerli bir durum seçiniz');
    }

    public function changeEmail(string $id, ChangeEmailRequest $request): RedirectResponse
    {
        $updated = $this->changeEmail->execute($id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'Kullanıcı e-posta adresi değiştirilmiş ve onay linki gönderilmiştir.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    public function verifyEmail(VerifyEmailRequest $request, $id): RedirectResponse
    {
        $verified = $this->verifyEmail->execute($id, $request->validated());
        return $verified
            ? Redirect::back()->with('success', 'Kullanıcıya e-posta adresi onay linki gönderilmiştir.')
            : Redirect::back()->with('error', 'Onay linki gönderilirken bir sorun oluştu, lütfen tekrar deneyiniz.');
    }

    public function checkEmail(CheckEmailRequest $request, $id): RedirectResponse
    {
        $checked = $this->checkEmail->execute($id, $request->validated());
        return $checked
            ? Redirect::back()->with('success', 'Kullanıcı e-posta adresi başarılı bir şekilde onaylandı.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    public function resetPassword(ResetPasswordRequest $request, $id): RedirectResponse
    {
        $status = $this->resetPassword->execute($id, $request->validated());
        return $status
            ? Redirect::back()->with('success', 'Şifre yenileme linki gönderildi.')
            : Redirect::back()->with('error', 'Şifre yenileme linki gönderilirken bir hata oluştu, lütfen tekrar deneyiniz');
    }
}
