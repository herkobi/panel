<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;


class Admin extends Controller
{
    public function index(): View
    {
        $activities = '';
        return view('admin', ['activities' => $activities]);
    }

    public function passive(User $user): View
    {
        return view('passive', ['user' => $user]);
    }
}
