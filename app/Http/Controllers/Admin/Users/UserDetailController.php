<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Users\Detail\UpdateStatus;
use App\Actions\Admin\Users\Detail\ChangeEmail;
use App\Actions\Admin\Users\Detail\ChangePassword;
use App\Actions\Admin\Users\Detail\CheckEmail;
use App\Actions\Admin\Users\Detail\VerifyEmail;
use App\Http\Requests\Admin\Users\ChangeEmailRequest;
use App\Http\Requests\Admin\Users\ChangePasswordRequest;
use App\Http\Requests\Admin\Users\CheckEmailRequest;
use App\Http\Requests\Admin\Users\UpdateStatusRequest;
use App\Http\Requests\Admin\Users\VerifyEmailRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserDetailController extends Controller
{

    private $updateStatus;
    private $changeEmail;
    private $verifyEmail;
    private $checkEmail;
    private $changePassword;

    public function __construct(
        UpdateStatus $updateStatus,
        ChangeEmail $changeEmail,
        VerifyEmail $verifyEmail,
        CheckEmail $checkEmail,
        ChangePassword $changePassword,
    ) {
        $this->updateStatus = $updateStatus;
        $this->changeEmail = $changeEmail;
        $this->verifyEmail = $verifyEmail;
        $this->checkEmail = $checkEmail;
        $this->changePassword = $changePassword;
    }

    /**
     * Kullanıcı durumunu güncelleme
     */
    public function updateStatus(UpdateStatusRequest $request, $id): RedirectResponse
    {
        $updated = $this->updateStatus->execute($id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'Kullanıcı durumu başarılı bir şekilde güncellendi.')
            : Redirect::back()->with('error', 'Hata; Lütfen geçerli bir durum seçiniz');
    }

    /**
     * Kullanıcıya e-posta adresini değiştirme
     *
     * @param  array<string, string>  $input
     */
    public function changeEmail(ChangeEmailRequest $request, $id): RedirectResponse
    {
        $updated = $this->changeEmail->execute($id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'Kullanıcı e-posta adresi değiştirilmiş ve onay linki gönderilmiştir.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    /**
     * Kullanıcıya e-posta adresini onay linki gönderme
     *
     * @param  array<string, string>  $input
     */
    public function verifyEmail(VerifyEmailRequest $request, $id): RedirectResponse
    {
        $verified = $this->verifyEmail->execute($id, $request->validated());
        return $verified
            ? Redirect::back()->with('success', 'Kullanıcıya e-posta adresi onay linki gönderilmiştir.')
            : Redirect::back()->with('error', 'Onay linki gönderilirken bir sorun oluştu, lütfen tekrar deneyiniz.');
    }

    /**
     * Kullanıcıya e-posta adresini onayla
     *
     * @param  array<string, string>  $input
     */
    public function checkEmail(CheckEmailRequest $request, $id): RedirectResponse
    {
        $checked = $this->checkEmail->execute($id, $request->validated());
        return $checked
            ? Redirect::back()->with('success', 'Kullanıcı e-posta adresi başarılı bir şekilde onaylandı.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    /**
     * Kullanıcı şifresini değiştirip yeni şifrenin e-posta ile gönderimi
     *
     * @param  array<string, string>  $input
     */
    public function changePassword(ChangePasswordRequest $request, $id): RedirectResponse
    {
        $changed = $this->changePassword->execute($id, $request->validated());
        return $changed
            ? Redirect::back()->with('success', 'Kullanıcı şifresi başarılı bir şekilde değiştirildi.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }
}
