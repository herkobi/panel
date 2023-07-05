<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usertags\UsertagCreateRequest;
use App\Http\Requests\Usertags\UsertagUpdateRequest;
use App\Models\Usertag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UsertagController extends Controller
{
    public function index(): View
    {
        $usertags = Usertag::paginate('15');
        return view('usertags.index', ['usertags' => $usertags]);
    }

    public function edit(Usertag $usertag): View
    {
        return view('usertags.edit', ['usertag' => $usertag]);
    }

    public function update(UsertagUpdateRequest $request, Usertag $usertag): RedirectResponse
    {
        if ($request->validated()) {
            $usertag->forceFill([
                'status' => $request->status,
                'name' => $request->name,
                'color' => $request->color,
                'desc' => $request->desc
            ])->save();
            return Redirect::route('panel.user.tags');
        }
    }

    public function store(UsertagCreateRequest $request)
    {
        if ($request->ajax() && $request->validated()) {
            Usertag::create($request->all());
            return response()->json(['status' => "success"]);
        }

        return response()->json(['status' => "error"]);
    }

    public function destroy(Usertag $usertag)
    {
        if ($usertag->users->count() > 0) {
            return Redirect::route('panel.user.tags')->with('Hata; Kategoriye ait kullanıcılar bulunmaktadır. Lütfen öncelikle kullanıcıları farklı kategorilere aktarınız');
        } else {
            $usertag->delete();
            return Redirect::route('panel.user.tags');
        }
    }
}
