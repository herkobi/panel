<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingsUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(Request $request): View
    {
        $date_formats = ['F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y'];
        $time_formats = ['g:i a', 'g:i A', 'H:i'];
        return view('settings.index', [
            'user' => $request->user(),
            'date_formats' => $date_formats,
            'time_formats' => $time_formats
        ]);
    }

    public function update(SettingsUpdateRequest $request, User $user)
    {
        if ($request->ajax() && $request->validated()) {
        }
    }
}
