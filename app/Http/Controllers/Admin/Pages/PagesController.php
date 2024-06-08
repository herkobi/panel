<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\PageCreateRequest;
use App\Http\Requests\Admin\Page\PageUpdateRequest;
use App\Actions\Admin\Pages\Create;
use App\Actions\Admin\Pages\Update;
use App\Actions\Admin\Pages\Delete;
use App\Actions\Admin\Pages\GetAll;
use App\Actions\Admin\Pages\GetOne;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PagesController extends Controller
{
    private $getAll;
    private $getOne;
    private $create;
    private $update;
    private $delete;

    public function __construct(
        GetAll $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function index(): View|RedirectResponse
    {

        if (!auth()->user()->can('page.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $pages = $this->getAll->execute();
        return view('admin.pages.index', [
            'pages' => $pages
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if (!auth()->user()->can('page.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        return view('admin.pages.create');
    }

    public function store(PageCreateRequest $request): RedirectResponse
    {
        if (!auth()->user()->can('page.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde oluşturuldu')
                : Redirect::back()->with('error', 'Sayfa eklenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function edit($id): View|RedirectResponse
    {
        if (!auth()->user()->can('page.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $page = $this->getOne->execute($id);
        return view('admin.pages.edit', [
            'page' => $page
        ]);
    }

    public function update(PageUpdateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('page.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Sayfa güncellenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function destroy($id): RedirectResponse
    {
        if (!auth()->user()->can('page.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        if (!auth()->user()->can('page.delete')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Sayfa silinirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

}
