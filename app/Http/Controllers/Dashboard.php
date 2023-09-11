<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class Dashboard extends Controller
{
    public function index(): View
    {
        $activities = '';
        return view('index', compact('activities'));
    }

    public function passive(User $user): View
    {
        return view('passive', compact('user'));
    }
}
