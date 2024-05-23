<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Actions\Admin\Profile\Activities;
use App\Actions\Admin\Profile\AuthLogs;
use App\Actions\Admin\Profile\GetUser;
use App\Actions\Admin\Profile\UpdateEmail;
use App\Actions\Admin\Profile\UpdatePassword;
use App\Actions\Admin\Profile\UpdateProfile;
use App\Actions\Admin\Profile\SettingsData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\EmailUpdateRequest;
use App\Http\Requests\Admin\Profile\PasswordUpdateRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $activities;
    private $authLogs;
    private $getUser;
    private $updateProfile;
    private $updateEmail;
    private $updatePassword;
    private $settingsData;

    public function __construct(
        Activities $activities,
        AuthLogs $authLogs,
        GetUser $getUser,
        UpdateProfile $updateProfile,
        UpdateEmail $updateEmail,
        UpdatePassword $updatePassword,
        SettingsData $settingsData
    ) {
        $this->activities = $activities;
        $this->authLogs = $authLogs;
        $this->getUser = $getUser;
        $this->updateProfile = $updateProfile;
        $this->updateEmail = $updateEmail;
        $this->updatePassword = $updatePassword;
        $this->settingsData = $settingsData;
    }

    public function index(): View
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        return view('admin.profile.index', [
            'user' => $user
        ]);
    }

    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $updated = $this->updateProfile->execute($user->id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'Profil bilgilerini başarılı bir şekilde güncellendi.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    public function updateEmail(EmailUpdateRequest $request): RedirectResponse
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $updated = $this->updateEmail->execute($user->id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'E-posta adresiniz başarılı bir şekilde güncellendi.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $updated = $this->updatePassword->execute($user->id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', 'Şifreniz başarılı bir şekilde güncellendi.')
            : Redirect::back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');
    }

    public function settings(): View
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $userSettings = json_decode($user->settings, true);
        $settings = $this->settingsData;
        return view('admin.profile.settings', [
            'user' => $user,
            'userSettings' => $userSettings,
            'settings' => $settings
        ]);
    }

    public function twofactor(): View
    {
        return view('admin.profile.twofactor');
    }

    public function activity(): View
    {
        $activities = $this->activities->execute(auth()->user()->id);
        return view('admin.profile.activity', [
            'activities' => $activities
        ]);
    }

    public function authlogs(): View
    {
        $authLogs = $this->authLogs->execute(auth()->user()->id);
        return view('admin.profile.authlogs', [
            'logs' => $authLogs
        ]);
    }
}
