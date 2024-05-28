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
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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

    public function index(): View
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
        $this->create->execute($request->validated());
        return Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde oluşturuldu');
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
        $this->update->execute($id, $request->validated());
        return Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde güncellendi');
    }

    public function destroy($id): RedirectResponse
    {
        $this->delete->execute($id);
        return Redirect::route('panel.pages')->with('success', 'Sayfanız başarılı bir şekilde silindi');
    }

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            'role_or_permission:manager|edit articles',
            new Middleware('role:author', only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']),
        ];
    }
}
