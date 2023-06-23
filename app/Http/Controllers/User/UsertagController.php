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
        $usertags = Usertag::all();
        return view('usercategories.index', compact('usertags'));
    }

    public function edit(Usertag $usertag): View
    {
        return view('usercategories.edit', compact('usertag'));
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

            notyf()->addSuccess('Kullanıcı kategorisi başarılı bir şekilde güncellendi');
            return Redirect::route('panel.user.tags');
        }
    }

    public function store(UsertagCreateRequest $request): RedirectResponse
    {
        dd($request);
        if ($request->validated()) {
            Usertag::create($request->all());
            notyf()->addSuccess('Kullanıcı kategorisi başarılı bir şekilde oluşturuldu');
            return Redirect::route('panel.user.tags');
        }
    }

    public function destroy(Usertag $usertag)
    {
        if ($usertag->users->count() > 0) {
            notyf()->addError('Hata; Kategoriye ait kullanıcılar bulunmaktadır. Lütfen öncelikle kullanıcıları farklı kategorilere aktarınız');
            return Redirect::route('panel.user.tags');
        } else {
            $usertag->delete();
            notyf()->addSuccess('Kategori başarılı bir şekilde silindi');
            return Redirect::route('panel.user.tags');
        }
    }
}
