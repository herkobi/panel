@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    @include('admin.tools.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h3 class="form-title border-bottom mb-3 pb-2">Önbellek Yönetimi</h3>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light rounded-3">
                                <div class="card-body">
                                    <div class="card-title fw-medium">Uygulama Önbelleği</div>
                                    <p>Uygulama tarafından kullanılan genel cache verilerini temizler, önbellekte
                                        tutulan tüm veri yapılarını sıfırlar.</p>
                                    <a href="#" title="Önbelleği Temizle" class="fw-medium" data-bs-toggle="modal"
                                        data-bs-target="#cacheModal">Temizle</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light rounded-3">
                                <div class="card-body">
                                    <div class="card-title fw-medium">Rota Önbelleği</div>
                                    <p>Rotaların daha hızlı yüklenmesi için önbelleğe alınan rota tanımlamalarını
                                        temizler.</p>
                                    <a href="#" title="Önbelleği Temizle" class="fw-medium" data-bs-toggle="modal"
                                        data-bs-target="#routeModal">Temizle</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light rounded-3">
                                <div class="card-body">
                                    <div class="card-title fw-medium">Yapılandırma Önbelleği</div>
                                    <p>config dosyalarının önbelleğe alınan sürümünü temizler, böylece
                                        yapılandırmalar dinamik olarak yüklenir.</p>
                                    <a href="#" title="Önbelleği Temizle" class="fw-medium" data-bs-toggle="modal"
                                        data-bs-target="#configModal">Temizle</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light rounded-3">
                                <div class="card-body">
                                    <div class="card-title fw-medium">Görünüm Önbelleği</div>
                                    <p>Derlenmiş Blade şablonlarının önbelleğe alınmış sürümlerini temizler, böylece
                                        şablonlar yeniden derlenir.</p>
                                    <a href="#" title="Önbelleği Temizle" class="fw-medium" data-bs-toggle="modal"
                                        data-bs-target="#viewModal">Temizle</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light rounded-3">
                                <div class="card-body">
                                    <div class="card-title fw-medium">Derlenmiş Önbellek</div>
                                    <p>Uygulamanın optimize edilmiş ve derlenmiş PHP dosyalarını temizler,
                                        performansla ilgili derlemeleri sıfırlar.</p>
                                    <a href="#" title="Önbelleği Temizle" class="fw-medium" data-bs-toggle="modal"
                                        data-bs-target="#optimizeModal">Temizle</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light rounded-3">
                                <div class="card-body">
                                    <div class="card-title fw-medium">Etkinlik Önbelleği</div>
                                    <p>Etkinlik ve event listener tanımlarını önbelleğe alan yapıyı temizler, event
                                        çözümlemesini sıfırlar.</p>
                                    <a href="#" title="Önbelleği Temizle" class="fw-medium" data-bs-toggle="modal"
                                        data-bs-target="#eventModal">Temizle</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Önbellek Yönetimi</h1>
                        </div>
                    </div>
                    <div class="list-group card-list-group">
                        <div class="list-group-item border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="data me-4">
                                    <div class="fw-bold mb-2">Uygulama Önbelleği</div>
                                    <div class="text-secondary">
                                        Uygulama önbelleği, veritabanı sorguları, nesne örnekleri ve diğer veriler gibi
                                        uygulama tarafından önceden hesaplanmış verileri depolar. Bu verilere ait tüm
                                        önbelleği temizler.
                                    </div>
                                </div>
                                <div class="action-btn text-lg-end">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#cacheModal">Temizle</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="data me-4">
                                    <div class="fw-bold mb-2">Sistem Önbelleği</div>
                                    <div class="text-secondary">
                                        Görüntüleme önbelleği, rota önbelleği, yapılandırma önbelleği ve uygulama
                                        önbelleği sisteme ait tüm önbelleği temizler.
                                    </div>
                                </div>
                                <div class="action-btn text-lg-end">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#optimizeModal">Temizle</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="data me-4">
                                    <div class="fw-bold mb-2">Görüntüleme Önbelleği</div>
                                    <div class="text-secondary">
                                        Derlenmiş görüntüler, daha hızlı sayfa yükleme süreleri için önceden
                                        işlenmiş PHP kodudur. Derlenmiş görüntü dosyalarına ait tüm önbelleği temizler.
                                    </div>
                                </div>
                                <div class="action-btn text-lg-end">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewModal">Temizle</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="data me-4">
                                    <div class="fw-bold mb-2">Rota Önbelleği</div>
                                    <div class="text-secondary">
                                        Rota önbelleği, URL'lerin belirli rotalara nasıl eşleştiğini depolar.
                                        Rotalara ait tüm önbelleği temizler.
                                    </div>
                                </div>
                                <div class="action-btn text-lg-end">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#routeModal">Temizle</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="data me-4">
                                    <div class="fw-bold mb-2">Yapılandırma Önbelleği</div>
                                    <div class="text-secondary">
                                        Yapılandırma önbelleği, uygulama ayarlarını depolar. Yapılandırılmış
                                        uygulama ayarlarına ait tüm önbelleği temizler.
                                    </div>
                                </div>
                                <div class="action-btn text-lg-end">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#configModal">Temizle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @include('admin.tools.include.modals')
@endsection
