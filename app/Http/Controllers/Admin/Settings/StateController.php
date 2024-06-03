<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Location\StateCreateRequest;
use App\Http\Requests\Admin\Settings\Location\StateUpdateRequest;
use App\Actions\Admin\Settings\Location\State\GetCountryStates;
use App\Actions\Admin\Settings\Location\State\GetOne;
use App\Actions\Admin\Settings\Location\State\Create;
use App\Actions\Admin\Settings\Location\State\Update;
use App\Actions\Admin\Settings\Location\State\Delete;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class StateController extends Controller
{

    private $getAll;
    private $getOne;
    private $create;
    private $update;
    private $delete;

    public function __construct(
        GetCountryStates $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete,
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function index($country): View|RedirectResponse
    {
        if (!auth()->user()->can('location.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $states = $this->getAll->execute($country);
        $country = $this->getAll->getCountry($country);
        return view('admin.settings.locations.state.index', [
            'states' => $states,
            'country' => $country
        ]);
    }

    public function create($country): View|RedirectResponse
    {
        if (!auth()->user()->can('location.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $country = $this->getAll->getCountry($country);
        return view('admin.settings.locations.state.create',[
            'country' => $country
        ]);
    }

    public function store(StateCreateRequest $request): RedirectResponse
    {
        if (!auth()->user()->can('location.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.settings.locations.states', $request->country_id)->with('success', 'Bölge başarılı bir şekilde eklendi')
                : Redirect::back()->with('error', 'Bölge başarılı bir şekilde eklendi');
    }

    public function edit($id): View|RedirectResponse
    {
        if (!auth()->user()->can('location.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $state = $this->getOne->execute($id);
        return view('admin.settings.locations.state.edit', [
            'state' => $state
        ]);
    }

    public function update(StateUpdateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('location.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($id, $request->validated());
        $state = $this->getOne->execute($id);
        return $updated
                ? Redirect::route('panel.settings.locations.states', $state->country_id)->with('success', 'Bölge bilgisi başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Bölge bilgisi başarılı bir şekilde güncellendi');
    }

    public function destroy($id): RedirectResponse
    {
        if (!auth()->user()->can('location.delete')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $state = $this->getOne->execute($id);
        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.settings.locations.states', $state->country_id)->with('success', 'Bölge başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Bölge başarılı bir şekilde silindi');
    }
}
