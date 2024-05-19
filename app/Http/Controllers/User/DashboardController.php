<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function index(): View
    {
        $activities = '';
        return view('user.dashboard.index', [
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
