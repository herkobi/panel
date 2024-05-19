<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TwoFactorAuthenticationController extends Controller
{
    public function index(Request $request): View
    {
        return view('user.profile.twofactor', [
            'user' => $request->user(),
        ]);
    }
}
