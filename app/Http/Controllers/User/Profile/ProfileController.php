<?php

namespace App\Http\Controllers\User\Profile;

use App\Actions\Admin\Profile\Activities;
use App\Actions\Admin\Profile\AuthLogs;
use App\Actions\Admin\Profile\GetUser;
use App\Actions\Admin\Profile\UpdateEmail;
use App\Actions\Admin\Profile\UpdatePassword;
use App\Actions\Admin\Profile\UpdateProfile;
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

    public function __construct(
        Activities $activities,
        AuthLogs $authLogs,
        GetUser $getUser,
        UpdateProfile $updateProfile,
        UpdateEmail $updateEmail,
        UpdatePassword $updatePassword
    ) {
        $this->activities = $activities;
        $this->authLogs = $authLogs;
        $this->getUser = $getUser;
        $this->updateProfile = $updateProfile;
        $this->updateEmail = $updateEmail;
        $this->updatePassword = $updatePassword;
    }

    public function index(): View
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        return view('user.profile.index', [
            'user' => $user
        ]);
    }

    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $updated = $this->updateProfile->execute($user->id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', __('admin/profile/profile.profile.update.success'))
            : Redirect::back()->with('error', __('admin/profile/profile.profile.update.error'));
    }

    public function updateEmail(EmailUpdateRequest $request): RedirectResponse
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $updated = $this->updateEmail->execute($user->id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', __('admin/profile/profile.email.update.success'))
            : Redirect::back()->with('error', __('admin/profile/profile.email.update.error'));
    }

    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        $updated = $this->updatePassword->execute($user->id, $request->validated());
        return $updated
            ? Redirect::back()->with('success', __('admin/profile/profile.password.update.success'))
            : Redirect::back()->with('error', __('admin/profile/profile.password.update.error'));
    }

    public function twofactor(): View
    {
        return view('user.profile.twofactor');
    }

    public function activity(): View
    {
        $activities = $this->activities->execute(auth()->user()->id);
        return view('user.profile.activity', [
            'activities' => $activities
        ]);
    }

    public function authlogs(): View
    {
        $authLogs = $this->authLogs->execute(auth()->user()->id);
        return view('user.profile.authlogs', [
            'logs' => $authLogs
        ]);
    }
}
