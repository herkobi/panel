<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Services\Admin\Settings\PageService;
use App\Actions\Admin\Settings\Page\Create;
use App\Actions\Admin\Settings\Page\Update;
use App\Actions\Admin\Settings\Page\Delete;
use App\Http\Requests\Admin\Settings\Page\PageUpdateRequest;
use App\Http\Requests\Admin\Settings\Page\PageCreateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PagesController extends Controller
{
    protected $pageService;
    protected $createPage;
    protected $updatePage;
    protected $deletePage;


    public function __construct(
        PageService $pageService,
        Create $createPage,
        Update $updatePage,
        Delete $deletePage
    ) {
        $this->pageService = $pageService;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->deletePage = $deletePage;
    }

    public function index(): View
    {
        $pages = $this->pageService->getAllPages();
        return view('admin.settings.pages.index', [
            'pages' => $pages
        ]);
    }

    public function create(): View
    {
        return view('admin.settings.pages.create');
    }

    public function store(PageCreateRequest $request): RedirectResponse
    {
        $created = $this->createPage->execute($request->validated());
        return $created
                ? Redirect::route('panel.settings.pages')->with('success', 'Sayfanız başarılı bir şekilde oluşturuldu')
                : Redirect::back()->with('error', 'Sayfa oluşturulurken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    public function edit($id): View
    {
        $page = $this->pageService->getPageById($id);
        return view('admin.settings.pages.edit', [
            'page' => $page
        ]);
    }

    public function update(PageUpdateRequest $request, $id): RedirectResponse
    {
        $updated = $this->updatePage->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.settings.pages')->with('success', 'Sayfanız başarılı bir şekilde güncellendi.')
                : Redirect::back()->with('error', 'Sayfa güncellenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    public function destroy($id): RedirectResponse
    {
        $deleted = $this->deletePage->execute($id);
        return $deleted
                ? Redirect::route('panel.settings.pages')->with('success', 'Sayfanız başarılı bir şekilde silindi.')
                : Redirect::back()->with('error', 'Sayfa silinirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }
}
