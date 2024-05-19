<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Actions\Admin\Profile\Activities;
use App\Actions\Admin\Profile\AuthLogs;
use App\Actions\Admin\Profile\GetUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{

    private $getUser;
    private $activities;
    private $authLogs;

    public function __construct(
        GetUser $getUser,
        Activities $activities,
        AuthLogs $authLogs
    ) {
        $this->getUser = $getUser;
        $this->activities = $activities;
        $this->authLogs = $authLogs;
    }

    public function index(): View
    {
        return view('admin.profile.index');
    }

    public function settings(): View
    {
        return view('admin.profile.settings');
    }

    public function twofactor(): View
    {
        return view('admin.profile.twofactor');
    }

    public function activity(): View
    {
        $user = $this->getUser->execute(auth()->user()->id);
        $activities = $this->activities->execute($user->id);
        return view('admin.profile.activity', [
            'activities' => $activities
        ]);
    }

    public function authlogs(): View
    {
        $user = $this->getUser->execute(auth()->user()->id);
        $authLogs = $this->authLogs->execute($user->id);
        return view('admin.profile.authlogs', [
            'logs' => $authLogs
        ]);
    }
}
