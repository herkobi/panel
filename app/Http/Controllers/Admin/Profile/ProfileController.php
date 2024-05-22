<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Actions\Admin\Profile\Activities;
use App\Actions\Admin\Profile\AuthLogs;
use App\Actions\Admin\Profile\GetUser;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $activities;
    private $authLogs;
    private $getUser;

    public function __construct(
        Activities $activities,
        AuthLogs $authLogs,
        GetUser $getUser
    ) {
        $this->activities = $activities;
        $this->authLogs = $authLogs;
        $this->getUser = $getUser;
    }

    public function index(): View
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        return view('admin.profile.index', [
            'user' => $user
        ]);
    }

    public function settings(): View
    {
        $user = $this->getUser->execute(auth()->user()?->id);
        return view('admin.profile.settings', [
            'user' => $user
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
