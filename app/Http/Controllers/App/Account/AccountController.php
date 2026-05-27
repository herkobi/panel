<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Account\UpdateAccountRequest;
use App\Http\Resources\App\Account\AccountResource;
use App\Services\App\Account\AccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    /**
     * Show the user's account settings page.
     */
    public function index(Request $request, AccountService $service): Response
    {
        $user = $request->user();
        $account = $user->account?->load('address');
        $address = $account?->address;

        $countryId = $request->string('country_id')->toString()
            ?: ($address?->country_id);
        $cityId = $request->string('city_id')->toString()
            ?: ($address?->city_id);

        $locationOptions = $service->locationOptions(
            $countryId ?: null,
            $cityId ?: null,
        );

        return Inertia::render('app/account/index', [
            'account' => $account
                ? AccountResource::make($account)
                : ['data' => null],
            'countries' => $locationOptions['countries'],
            'cities' => $locationOptions['cities'],
            'districts' => $locationOptions['districts'],
        ]);
    }

    /**
     * Update the user's account information.
     */
    public function update(UpdateAccountRequest $request, AccountService $service): RedirectResponse
    {
        $service->updateForUser($request->user(), [
            'title' => $request->validated('title'),
            'address' => $request->validated('address'),
            'postal_code' => $request->validated('postal_code'),
            'district_id' => $request->validated('district_id'),
            'city_id' => $request->validated('city_id'),
            'country_id' => $request->validated('country_id'),
        ]);

        return back()
            ->with('toast', ['type' => 'success', 'message' => __('Hesap bilgileri güncellendi.')]);
    }
}
