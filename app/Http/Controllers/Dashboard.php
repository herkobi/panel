<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Activitylog\Contracts\Activity
class Dashboard extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function passive(User $user): View
    {
        return view('passive', compact('user'));
    }
}
