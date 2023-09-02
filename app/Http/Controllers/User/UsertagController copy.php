<?php

namespace App\Http\Controllers\User;

use App\Events\LogEvent;
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

        if ($request->validated()) {

            $usertag->status = $request->status;
            $usertag->name = $request->name;
            $usertag->color = $request->color;
            $usertag->desc = $request->desc;
            $usertag->save();

            event(new LogEvent(['type' => 'info', 'model' => 'usertag', 'method' => 'update', 'status' => 'success', 'data' => $usertag->name]));
            return Redirect::route('panel.user.tags')->with('success', __('usertag.update.success.message'));
        }

        event(new LogEvent(['type' => 'warning', 'model' => 'usertag', 'method' => 'update.validation', 'status' => 'error', 'data' => $usertag->name, 'error' => $request->validated()->messages()->all()[0]]));
        return Redirect::back()->with('error', $request->validated()->messages()->all()[0])->withInput();
    }

    public function store(UsertagCreateRequest $request): JsonResponse
    {

        if ($request->ajax()) {
            if($request->validated()) {
                $usertag = Usertag::create($request->all());

                event(new LogEvent(['type' => 'info', 'model' => 'usertag', 'method' => 'create', 'status' => 'success', 'data' => $usertag->name]));
                return response()->json(['status' => "success"]);
            }

            event(new LogEvent(['type' => 'warning', 'model' => 'usertag', 'method' => 'update.validation', 'status' => 'error', 'error' => $request->validated()->messages()->all()[0]]));
            return response()->json(["status" => "error", "message" => $request->validated()->messages()->all()[0]]);
        }

        Log::warning( __("global.critical.error") );
        return response()->json(['status' => "error", "message" => __("global.critical.error")]);
    }

    public function destroy(Request $request, Usertag $usertag): JsonResponse
    {
        if ($request->ajax()) {

            if ($usertag->users()->count() > 0) {

                Log::warning(
                    __("usertag.log.delete.confirm.error", [
                        'authuser' => auth()->user()->name,
                        'ip' => request()->ip(),
                        'name' => $request->name
                    ])
                );

                return response()->json([
                    "status" => "error",
                    "message" => __("usertag.log.delete.confirm.error", [
                        'authuser' => auth()->user()->name,
                        'ip' => request()->ip(),
                        'name' => $request->name
                    ])
                ]);
            } else {

                $usertag->delete();

                Log::info(
                    __("activity.delete.success", [
                        'authuser' => auth()->user()->name,
                        'name' => $usertag->name
                    ])
                );

                return response()->json(['status' => "success"]);
            }
        }

        Log::warning( __("global.critical.error") );
        return response()->json(['status' => "error", "message" => __("global.critical.error")]);

    }
}
