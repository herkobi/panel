<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class Admin extends Controller
{
    public function index(): View
    {
        $activities = Activity::limit('1');
        return view('admin', compact('activities'));
    }

    public function passive(User $user): View
    {
        return view('passive', compact('user'));
    }
}
