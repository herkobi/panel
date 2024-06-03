<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Tools\Cache\ClearCache;
use App\Actions\Admin\Tools\Cache\ClearConfig;
use App\Actions\Admin\Tools\Cache\ClearOptimize;
use App\Actions\Admin\Tools\Cache\ClearRoute;
use App\Actions\Admin\Tools\Cache\ClearView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CacheController extends Controller
{

    private $clearCache;
    private $clearConfig;
    private $clearOptimize;
    private $clearRoute;
    private $clearView;

    public function __construct(
        ClearCache $clearCache,
        ClearConfig $clearConfig,
        ClearOptimize $clearOptimize,
        ClearRoute $clearRoute,
        ClearView $clearView,
    ) {
        $this->clearCache = $clearCache;
        $this->clearConfig = $clearConfig;
        $this->clearOptimize = $clearOptimize;
        $this->clearRoute = $clearRoute;
        $this->clearView = $clearView;
    }

    public function index(): View
    {
        if (!auth()->user()->can('tools.cache.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        return view('admin.tools.cache.index');
    }

    /**
     * Uygulama önbelleğini temizler.
     * Uygulama önbelleği, veritabanı sorguları, nesne örnekleri ve diğer veriler gibi uygulama tarafından önceden hesaplanmış verileri depolar.
     * Bu komutu, veritabanınızda değişiklik yaptıktan veya uygulamanızın performansında bir düşüş fark ettikten sonra kullanabilirsiniz.
     */
    public function cache(): RedirectResponse
    {
        if (!auth()->user()->can('tools.cache.cache')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $cleared = $this->clearCache->execute();
        return $cleared === 0
            ? Redirect::back()->with('success', 'Uygulama önbelliği başarılı bir şekilde temizlendi')
            : Redirect::back()->with('error', 'Önbellek temizlenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Önbelleğe alınmış tüm verilerini tek seferde temizler.
     * Görüntüleme, rota, yapılandırma ve uygulama önbelleği gibi.
     * Bu komutu, uygulamanızda büyük değişiklikler yaptıktan sonra veya önbelleğin hatalı olduğunu düşündüğünüz durumlarda kullanabilirsiniz.
     */
    public function optimize(): RedirectResponse
    {
        if (!auth()->user()->can('tools.cache.optimize')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $cleared = $this->clearOptimize->execute();
        return $cleared === 0
            ? Redirect::back()->with('success', 'Uygulamaya, rota, yapılandırma ve görünüm önbelleği başarılı bir şekilde temizlendi')
            : Redirect::back()->with('error', 'Önbellek temizlenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Derlenmiş görüntüleme önbelleğini temizler.
     * Derlenmiş görüntüler, daha hızlı sayfa yükleme süreleri için önceden işlenmiş PHP kodudur.
     * Bu komutu, yeni bir şablon oluşturduktan veya mevcut bir şablonda değişiklik yaptıktan sonra kullanabilirsiniz.
     */
    public function view(): RedirectResponse
    {
        if (!auth()->user()->can('tools.cache.view')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $cleared = $this->clearView->execute();
        return $cleared === 0
            ? Redirect::back()->with('success', 'Görünüm önbelliği başarılı bir şekilde temizlendi')
            : Redirect::back()->with('error', 'Önbellek temizlenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Rota önbelleğini temizler.
     * Rota önbelleği, URL'lerin belirli rotalara nasıl eşleştiğini depolar.
     * Bu komutu, yeni bir rota ekledikten veya mevcut bir rotanın yolunu değiştirdikten sonra kullanabilirsiniz.
     */
    public function route(): RedirectResponse
    {
        if (!auth()->user()->can('tools.cache.route')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $cleared = $this->clearRoute->execute();
        return $cleared === 0
            ? Redirect::back()->with('success', 'Rota önbelliği başarılı bir şekilde temizlendi')
            : Redirect::back()->with('error', 'Önbellek temizlenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    /**
     * Yapılandırma önbelleğini temizler.
     * Yapılandırma önbelleği, uygulama ayarlarını depolar.
     * Bu komutu, bir yapılandırma ayarını değiştirdikten sonra kullanabilirsiniz.
     */
    public function config(): RedirectResponse
    {
        if (!auth()->user()->can('tools.cache.config')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $cleared = $this->clearConfig->execute();
        return $cleared === 0
            ? Redirect::back()->with('success', 'Yapılandırma önbelliği başarılı bir şekilde temizlendi')
            : Redirect::back()->with('error', 'Önbellek temizlenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }
}
