<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index(): View
    {
        $lastActivity = Activity::all()->last();
        $activities = $lastActivity->changes;
        return view('admin.dashboard.index', [
            'activities' => $activities
        ]);
    }

    public function passive(User $user): View
    {
        return view('layouts.passive', [
            'user' => $user
        ]);
    }
}
