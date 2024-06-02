<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Accounts\Detail\UpdateStatus;
use App\Actions\Admin\Accounts\Detail\ChangeEmail;
use App\Actions\Admin\Accounts\Detail\ChangePassword;
use App\Actions\Admin\Accounts\Detail\CheckEmail;
use App\Actions\Admin\Accounts\Detail\ResetPassword;
use App\Actions\Admin\Accounts\Detail\VerifyEmail;
use App\Http\Requests\Admin\Accounts\ChangeEmailRequest;
use App\Http\Requests\Admin\Accounts\ChangePasswordRequest;
use App\Http\Requests\Admin\Accounts\CheckEmailRequest;
use App\Http\Requests\Admin\Accounts\ResetPasswordRequest;
use App\Http\Requests\Admin\Accounts\UpdateStatusRequest;
use App\Http\Requests\Admin\Accounts\VerifyEmailRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

class AccountDetailController extends Controller
{

    private $updateStatus;
    private $changeEmail;
    private $verifyEmail;
    private $checkEmail;
    private $changePassword;
    private $resetPassword;

    public function __construct(
        UpdateStatus $updateStatus,
        ChangeEmail $changeEmail,
        VerifyEmail $verifyEmail,
        CheckEmail $checkEmail,
        ChangePassword $changePassword,
        ResetPassword $resetPassword,
    ) {
        $this->updateStatus = $updateStatus;
        $this->changeEmail = $changeEmail;
        $this->verifyEmail = $verifyEmail;
        $this->checkEmail = $checkEmail;
        $this->changePassword = $changePassword;
        $this->resetPassword = $resetPassword;
    }

    /**
     * Kullanıcı durumunu güncelleme
     */
    public function updateStatus(UpdateStatusRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('account.status.update')) {
            return Redirect::back()->with('error', 'Bu işlemi yapmak için izniniz bulunmamaktadır.');
        }

        $updated = $this->updateStatus->execute($id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', __('admin/accounts/accounts.update.status.success'))
            : Redirect::back()->with('error', __('admin/accounts/accounts.update.status.error'));
    }

    /**
     * Kullanıcıya e-posta adresini değiştirme
     *
     * @param  array<string, string>  $input
     */
    public function changeEmail(ChangeEmailRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('account.email.update')) {
            return Redirect::back()->with('error', 'Bu işlemi yapmak için izniniz bulunmamaktadır.');
        }

        $updated = $this->changeEmail->execute($id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', __('admin/accounts/accounts.change.email.success'))
            : Redirect::back()->with('error', __('admin/accounts/accounts.change.email.error'));
    }

    /**
     * Kullanıcıya e-posta adresini onay linki gönderme
     *
     * @param  array<string, string>  $input
     */
    public function verifyEmail(VerifyEmailRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('account.email.send')) {
            return Redirect::back()->with('error', 'Bu işlemi yapmak için izniniz bulunmamaktadır.');
        }

        $verified = $this->verifyEmail->execute($id, $request->validated());
        return $verified
            ? Redirect::back()->with('success', __('admin/accounts/accounts.verify.email.success'))
            : Redirect::back()->with('error', __('admin/accounts/accounts.verify.email.error'));
    }

    /**
     * Kullanıcıya e-posta adresini onayla
     *
     * @param  array<string, string>  $input
     */
    public function checkEmail(CheckEmailRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('account.email.verified')) {
            return Redirect::back()->with('error', 'Bu işlemi yapmak için izniniz bulunmamaktadır.');
        }

        $checked = $this->checkEmail->execute($id, $request->validated());
        return $checked
            ? Redirect::back()->with('success', __('admin/accounts/accounts.check.email.success'))
            : Redirect::back()->with('error', __('admin/accounts/accounts.check.email.error'));
    }

    /**
     * Kullanıcı şifresini değiştirip yeni şifrenin e-posta ile gönderimi
     *
     * @param  array<string, string>  $input
     */
    public function changePassword(ChangePasswordRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('account.password.change')) {
            return Redirect::back()->with('error', 'Bu işlemi yapmak için izniniz bulunmamaktadır.');
        }

        $changed = $this->changePassword->execute($id, $request->validated());
        return $changed
            ? Redirect::back()->with('success', __('admin/accounts/accounts.change.password.success'))
            : Redirect::back()->with('error', __('admin/accounts/accounts.change.password.error'));
    }

    /**
     * Kullanıcıya şifre yenileme linkinin e-posta ile gönderimi
     *
     * @param  array<string, string>  $input
     */
    public function resetPassword(ResetPasswordRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('account.password.reset')) {
            return Redirect::back()->with('error', 'Bu işlemi yapmak için izniniz bulunmamaktadır.');
        }

        $status = $this->resetPassword->execute($id, $request->validated());
        return $status === Password::RESET_LINK_SENT
            ? Redirect::back()->with('success', __('admin/accounts/accounts.reset.password.success'))
            : Redirect::back()->with('error', __('admin/accounts/accounts.reset.password.error'));
    }
}
