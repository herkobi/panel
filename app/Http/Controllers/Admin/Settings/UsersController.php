<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Settings\User\Create;
use App\Actions\Admin\Settings\User\Delete;
use App\Actions\Admin\Settings\User\StatusUpdate;
use App\Actions\Admin\Settings\User\ChangeEmail;
use App\Actions\Admin\Settings\User\VerifyEmail;
use App\Actions\Admin\Settings\User\CheckEmail;
use App\Actions\Admin\Settings\User\ChangePassword;
use App\Actions\Admin\Settings\User\ResetPassword;
use App\Http\Requests\Admin\Settings\Users\VerifyEmailRequest;
use App\Http\Requests\Admin\Settings\Users\ChangeEmailRequest;
use App\Http\Requests\Admin\Settings\Users\ChangePasswordRequest;
use App\Http\Requests\Admin\Settings\Users\CheckEmailRequest;
use App\Http\Requests\Admin\Settings\Users\ResetPasswordRequest;
use App\Http\Requests\Admin\Settings\Users\StatusUpdateRequest;
use App\Http\Requests\Admin\Settings\Users\UserCreateRequest;
use App\Mail\NewAdminEmail;
use App\Services\Admin\Settings\UserService;
use App\Services\Admin\Tools\AuthLogsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UsersController extends Controller
{
    protected $userService;
    protected $authLogs;
    protected $createUser;
    protected $deleteUser;
    protected $statusUpdate;
    protected $changeEmail;
    protected $verifyEmail;
    protected $checkEmail;
    protected $changePassword;
    protected $resetPassword;


    public function __construct(
        UserService $userService,
        AuthLogsService $authLogs,
        Create $createUser,
        Delete $deleteUser,
        StatusUpdate $statusUpdate,
        ChangeEmail $changeEmail,
        VerifyEmail $verifyEmail,
        CheckEmail $checkEmail,
        ChangePassword $changePassword,
        ResetPassword $resetPassword,
    ) {
        $this->userService = $userService;
        $this->authLogs = $authLogs;
        $this->createUser = $createUser;
        $this->deleteUser = $deleteUser;
        $this->statusUpdate = $statusUpdate;
        $this->changeEmail = $changeEmail;
        $this->verifyEmail = $verifyEmail;
        $this->checkEmail = $checkEmail;
        $this->changePassword = $changePassword;
        $this->resetPassword = $resetPassword;
    }
    public function index(): View
    {
        $users = $this->userService->getAllUsers();
        return view('admin.settings.users.index', [
            'users' => $users
        ]);
    }

    public function detail(string $id): View
    {
        $user = $this->userService->getUserById($id);
        $activities = $this->userService->getUserActivity($id);
        return view('admin.settings.users.detail', [
            'user' => $user,
            'activities' => $activities
        ]);
    }

    public function authlogs(string $id): View
    {
        $user = $this->userService->getUserById($id);
        $logs = $this->authLogs->userAuthLogs($user->id);
        return view('admin.settings.users.authlogs', [
            'user' => $user,
            'logs' => $logs
        ]);
    }

    public function create(): View
    {
        return view('admin.settings.users.create');
    }

    public function store(UserCreateRequest $request): RedirectResponse
    {
        $created = $this->createUser->execute($request->validated());

        if($request->has('verifyemail')) {
            $created->sendEmailVerificationNotification();
        }

        if ($request->has('sendemail')) {
            Mail::to($created->email)->send(new NewAdminEmail($created, $request->password));
        }

        return $created
                ? Redirect::route('panel.settings.users')->with('success', 'Yeni kullanıcı başarılı bir şekilde oluşturuldu')
                : Redirect::back()->with('error', 'Yeni kullanıcı oluşturulurken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->deleteUser->execute($id);
        return $deleted
                ? Redirect::route('panel.settings.users')->with('success', 'Kullanıcı bir şekilde silindi.')
                : Redirect::back()->with('error', 'Kullanıcı silinirken bir hata oluştu. Lütfen tekrar deneyiniz.');
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

    public function changePassword(ChangePasswordRequest $request, $id): RedirectResponse
    {
        $changed = $this->changePassword->execute($id, $request->validated());
        return $changed
            ? Redirect::back()->with('success', 'Kullanıcı şifresi başarılı bir şekilde değiştirildi.')
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
