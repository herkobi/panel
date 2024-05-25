<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TwoFactorAuthenticationController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.profile.twofactor', [
            'user' => $request->user(),
        ]);
    }

    public function confirm(Request $request)
    {
        $confirmed = $request->user()->confirmTwoFactorAuth($request->code);
        if (!$confirmed) {
            return back()->withErrors('Invalid Two Factor Authentication code');
        }

        return back();
    }
}
