<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Actions\Admin\Profile\Activities;
use App\Actions\Admin\Profile\AuthLogs;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $activities;
    private $authLogs;

    public function __construct(
        Activities $activities,
        AuthLogs $authLogs
    ) {
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
