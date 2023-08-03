<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usertags\UsertagCreateRequest;
use App\Http\Requests\Usertags\UsertagUpdateRequest;
use App\Models\Usertag;
use App\Utils\PaginateCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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

        $ip = request()->ip();
        $authuser = auth()->user()->name;

        if ($request->validated()) {

            $usertag->status = $request->status;
            $usertag->name = $request->name;
            $usertag->color = $request->color;
            $usertag->desc = $request->desc;
            $usertag->save();

            activity('admin')
                ->performedOn($usertag) // kime yapıldı
                ->causedBy(auth()->user()->id) // kim yaptı
                ->event('update') // ne yaptı
                ->withProperties(['title' => 'Kullanıcı Etiketi Güncelleme']) // işlem başlığı
                ->log($authuser. ', '.$usertag->name. ' isimli etiketi güncelledi'); // açıklama

            Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$usertag->name} isimli etiketi güncelledi");

            return Redirect::route('panel.user.tags')->with('success', __('usertag.update.success'));
        }

        Log::warning("{$authuser}, {$ip} ip adresi üzerinden, {$usertag} güncellerken bir sorun ile karşılaştı: Hata içeriği:" .$request->validated()->messages()->all()[0]);

        return Redirect::back()->with('error', $request->validated()->messages()->all()[0])->withInput();
    }

    public function store(UsertagCreateRequest $request): JsonResponse
    {

        $ip = request()->ip();
        $authuser = auth()->user()->name;

        if ($request->ajax() && $request->validated()) {
            $usertag = Usertag::create($request->all());

            activity('admin')
                ->performedOn($usertag) // kime yapıldı
                ->causedBy(auth()->user()->id) // kim yaptı
                ->event('create') // ne yaptı
                ->withProperties(['title' => 'Yeni Kullanıcı Etiketi']) // işlem başlığı
                ->log($authuser. ', '.$usertag->name. ' isimli yeni etiket oluşturdu'); // açıklama

            Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$usertag->name} isimli yeni etiket oluşturdu");

            return response()->json(['status' => "success"]);
        }

        Log::info("{$authuser}, {$ip} ip adresi üzerinden, etiket oluştururken hata oluştu");

        return response()->json(['status' => "error"]);
    }

    public function destroy(Request $request, Usertag $usertag): JsonResponse
    {
        if ($request->ajax()) {
            $ip = request()->ip();
            $authuser = auth()->user()->name;

            if ($usertag->users->count() > 0) {
                Log::warning("{$authuser}, {$ip} ip adresi üzerinden, $usertag->name isimli etiketi atanmış kullanıcılar olduğundan silemedi.");
                return response()->json(['status' => "error"]);
            } else {
                $usertag->delete();

                activity('admin')
                    ->performedOn($usertag) // kime yapıldı
                    ->causedBy(auth()->user()->id) // kim yaptı
                    ->event('delete') // ne yaptı
                    ->withProperties(['title' => 'Kullanıcı Etiketi Silme']) // işlem başlığı
                    ->log($authuser. ', '.$usertag->name. ' isimli etiketi sildi'); // açıklama

                Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$usertag->name} isimli etiketi sildi");

                return response()->json(['status' => "success"]);
            }
        }

    }
}
