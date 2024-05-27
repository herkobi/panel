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

        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $pages = $this->getAll->execute();
        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(PageCreateRequest $request): RedirectResponse
    {
        $this->create->execute($request->validated());
        return Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde oluşturuldu');
    }

    public function edit($id): View
    {
        $page = $this->getOne->execute($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageUpdateRequest $request, $id): RedirectResponse
    {
        $this->update->execute($id, $request->validated());
        return Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde güncellendi');
    }

    public function destroy($id): RedirectResponse
    {
        $this->delete->execute($id);
        return Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde silindi');
    }
}
