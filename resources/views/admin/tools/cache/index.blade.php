@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Araçlar',
                    'title' => 'Önbellek Yönetimi',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.tools.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Önbellek Yönetimi</h1>
                        </div>
                        <div class="list-group card-list-group">
                            <div class="list-group-item border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="data me-3">
                                        <div class="fw-bold mb-2">Uygulama Önbelleği</div>
                                        <div class="text-secondary">
                                            Uygulama önbelleği, veritabanı sorguları, nesne örnekleri ve diğer veriler gibi
                                            uygulama tarafından önceden hesaplanmış verileri depolar. Bu verilere ait tüm
                                            önbelleği temizler.
                                        </div>
                                    </div>
                                    <div class="action-btn text-lg-end">
                                        <button type="button" class="btn btn-outline-secondary p-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-cache">Temizle</button>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="data me-3">
                                        <div class="fw-bold mb-2">Sistem Önbelleği</div>
                                        <div class="text-secondary">
                                            Görüntüleme önbelleği, rota önbelleği, yapılandırma önbelleği ve uygulama
                                            önbelleği sisteme ait tüm önbelleği temizler.
                                        </div>
                                    </div>
                                    <div class="action-btn text-lg-end">
                                        <button type="button" class="btn btn-outline-secondary p-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-optimize">Temizle</button>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="data me-3">
                                        <div class="fw-bold mb-2">Görüntüleme Önbelleği</div>
                                        <div class="text-secondary">
                                            Derlenmiş görüntüler, daha hızlı sayfa yükleme süreleri için önceden işlenmiş
                                            PHP kodudur. Derlenmiş görüntü dosyalarına ait tüm önbelleği temizler.
                                        </div>
                                    </div>
                                    <div class="action-btn text-lg-end">
                                        <button type="button" class="btn btn-outline-secondary p-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-view">Temizle</button>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="data me-3">
                                        <div class="fw-bold mb-2">Rota Önbelleği</div>
                                        <div class="text-secondary">
                                            Rota önbelleği, URL'lerin belirli rotalara nasıl eşleştiğini depolar. Rotalara
                                            ait tüm önbelleği temizler.
                                        </div>
                                    </div>
                                    <div class="action-btn text-lg-end">
                                        <button type="button" class="btn btn-outline-secondary p-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-route">Temizle</button>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="data me-3">
                                        <div class="fw-bold mb-2">Yapılandırma Önbelleği</div>
                                        <div class="text-secondary">
                                            Yapılandırma önbelleği, uygulama ayarlarını depolar. Yapılandırılmış
                                            uygulama ayarlarına ait tüm önbelleği temizler.
                                        </div>
                                    </div>
                                    <div class="action-btn text-lg-end">
                                        <button type="button" class="btn btn-outline-secondary p-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-config">Temizle</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-cache" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.tools.cache.clear.cache') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="text-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            <h3>Dikkat</h3>
                        </div>
                        <div class="text-secondary mb-3">Uygulama önbelleğini temizlemek üzeresiniz.</div>
                        <p>Uygulama önbelleği, veritabanı sorguları, nesne örnekleri ve diğer veriler gibi uygulama
                            tarafından önceden hesaplanmış verileri depolar.</p>
                        <p>Bu komutu, veritabanınızda değişiklik yaptıktan veya uygulamanızın performansında bir düşüş fark
                            ettikten sonra kullanabilirsiniz.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M13 18l6 -6" />
                                    <path d="M13 6l6 6" />
                                </svg>
                                Devam Et ve Temizle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-optimize" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.tools.cache.clear.optimize.cache') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="text-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            <h3>Dikkat</h3>
                        </div>
                        <div class="text-secondary mb-3">Önbelleğe alınmış tüm verileri temizlemek üzeresiniz.</div>
                        <p>Görüntüleme önbelleği, rota önbelleği, yapılandırma önbelleği ve uygulama önbelleği gibi.</p>
                        <p>Bu komutu, uygulamanızda büyük değişiklikler yaptıktan sonra veya önbelleğin hatalı olduğunu
                            düşündüğünüz durumlarda kullanabilirsiniz.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M13 18l6 -6" />
                                    <path d="M13 6l6 6" />
                                </svg>
                                Devam Et ve Temizle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-view" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.tools.cache.clear.view.cache') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="text-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            <h3>Dikkat</h3>
                        </div>
                        <div class="text-secondary mb-3">Derlenmiş görüntüleme önbelleğini temizlemek üzeresiniz.</div>
                        <p>Derlenmiş görüntüler, daha hızlı sayfa yükleme süreleri için önceden işlenmiş PHP kodudur.</p>
                        <p>Bu komutu, yeni bir şablon oluşturduktan veya mevcut bir şablonda değişiklik yaptıktan sonra
                            kullanabilirsiniz.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M13 18l6 -6" />
                                    <path d="M13 6l6 6" />
                                </svg>
                                Devam Et ve Temizle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-route" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.tools.cache.clear.route.cache') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="text-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            <h3>Dikkat</h3>
                        </div>
                        <div class="text-secondary mb-3">Rota önbelleğini temizlemek üzeresiniz.</div>
                        <p>Rota önbelleği, URL'lerin belirli rotalara nasıl eşleştiğini depolar.</p>
                        <p>Bu komutu, yeni bir rota ekledikten veya mevcut bir rotanın yolunu değiştirdikten sonra
                            kullanabilirsiniz.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M13 18l6 -6" />
                                    <path d="M13 6l6 6" />
                                </svg>
                                Devam Et ve Temizle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-config" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.tools.cache.clear.config.cache') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="text-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            <h3>Dikkat</h3>
                        </div>
                        <div class="text-secondary mb-3">Yapılandırma önbelleğini temizlemek üzeresiniz.</div>
                        <p>Yapılandırma önbelleği, uygulama ayarlarını depolar.</p>
                        <p>Bu komutu, bir yapılandırma ayarını değiştirdikten sonra kullanabilirsiniz.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M13 18l6 -6" />
                                    <path d="M13 6l6 6" />
                                </svg>
                                Devam Et ve Temizle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (Session::has('success'))
        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="modal-status bg-success"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        <h3>Başarılı</h3>
                        <div class="text-secondary">{{ Session::get('success') }}</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-success mx-auto" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="module">
            var successModal = new bootstrap.Modal(document.getElementById('modal-success'), {})
            successModal.toggle()
        </script>
    @endif
    @if (Session::has('error') || $errors->any())
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v4" />
                            <path
                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                            <path d="M12 16h.01" />
                        </svg>
                        <h3>Hata</h3>
                        @if ($errors->any())
                            <div class="text-secondary">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-secondary">{{ Session::get('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="module">
            var errorModal = new bootstrap.Modal(document.getElementById('modal-danger'), {})
            errorModal.toggle()
        </script>
    @endif
@endsection
