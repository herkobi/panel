<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usertags\UsertagCreateRequest;
use App\Http\Requests\Usertags\UsertagUpdateRequest;
use App\Models\Usertag;
use App\Utils\PaginateCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UsertagController extends Controller
{
    public function index(): View
    {
        $usertags = PaginateCollection::paginate(Usertag::get(), 25);
        return view('usertags.index', ['usertags' => $usertags]);
    }

    public function edit(Usertag $usertag): View
    {
        return view('usertags.edit', ['usertag' => $usertag]);
    }

    public function update(UsertagUpdateRequest $request, Usertag $usertag): RedirectResponse
    {
        if ($request->validated()) {

            $usertag->status = $request->status;
            $usertag->name = $request->name;
            $usertag->color = $request->color;
            $usertag->desc = $request->desc;
            $usertag->save();

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
            return Redirect::route('panel.user.tags')->with('errors', 'Hata; Kategoriye ait kullanıcılar bulunmaktadır. Lütfen öncelikle kullanıcıları farklı kategorilere aktarınız');
        } else {
            $usertag->delete();
            return Redirect::route('panel.user.tags');
        }
    }
}
