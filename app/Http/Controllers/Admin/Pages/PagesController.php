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
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class PagesController extends Controller implements HasMiddleware
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
        $pages = $this->getAll->execute();
        return view('admin.pages.index', [
            'pages' => $pages
        ]);
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(PageCreateRequest $request): RedirectResponse
    {
        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde oluşturuldu')
                : Redirect::back()->with('error', 'Sayfa eklenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function edit($id): View
    {
        $page = $this->getOne->execute($id);
        return view('admin.pages.edit', [
            'page' => $page
        ]);
    }

    public function update(PageUpdateRequest $request, $id): RedirectResponse
    {
        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Sayfa güncellenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function destroy($id): RedirectResponse
    {
        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Sayfa silinirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public static function middleware(): array
    {
        return [
            'role:Super Admin',
            new Middleware(PermissionMiddleware::using('index,create,store,edit,update,destroy')),
        ];
    }

}
