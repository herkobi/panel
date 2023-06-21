<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsertagCreateRequest;
use App\Http\Requests\UsertagUpdateRequest;
use App\Models\Usertag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UsertagController extends Controller
{
    public function index(): View
    {
        $tags = Usertag::all();
        return view('users.categories.index', compact('tags'));
    }

    public function edit(Usertag $usertag): View
    {

        return view('users.categories.index', compact('usertag'));
    }

    public function update(UsertagUpdateRequest $request, Usertag $usertag): RedirectResponse
    {
        if ($request->validated()) {
            $usertag->forceFill([
                'name' => $request->name,
                'color' => $request->color,
                'desc' => $request->desc
            ])->save();

            notyf()->addSuccess('Kullanıcı kategorisi başarılı bir şekilde güncellendi');
            return Redirect::back();
        }
    }

    public function store(UsertagCreateRequest $request, Usertag $usertag): RedirectResponse
    {
        if ($request->validated()) {
            Usertag::create($request->all());
            notyf()->addSuccess('Kullanıcı kategorisi başarılı bir şekilde oluşturuldu');
            return Redirect::back();
        }
    }

    public function destroy(Usertag $usertag)
    {
        if (count($usertag->users->count()) > 0) {
            notyf()->addError('Hata; Kategoriye ait kullanıcılar bulunmaktadır. Lütfen öncelikle kullanıcıları farklı kategorilere aktarınız');
            return Redirect::back();
        } else {
            $usertag->delete();
            notyf()->addSuccess('Kategori başarılı bir şekilde silindi');
            return Redirect::route('panel.users.tags');
        }
    }
}
