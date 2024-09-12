<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.index');
    }

    public function passive(User $user): View
    {
        return view('layouts.passive', [
            'user' => $user
        ]);
    }
}
