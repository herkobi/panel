<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;


class Admin extends Controller
{
    public function index(): View
    {

        $health = Health::checks([
            CacheCheck::new(),
            UsedDiskSpaceCheck::new(),
            DatabaseCheck::new(),
            DebugModeCheck::new()->unless(app()->environment('local')),
        ]);

        $activities = Activity::limit('1');
        return view('admin', ['activities' => $activities, 'health' => $health]);
    }

    public function passive(User $user): View
    {
        return view('passive', ['user' => $user]);
    }
}
