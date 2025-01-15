<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\AuthUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{

    use AuthUser;

    protected $accept;

    public function __construct() {
        $this->initializeAuthUser();
    }

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
