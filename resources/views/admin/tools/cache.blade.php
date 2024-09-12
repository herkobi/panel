@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                    @include('admin.tools.include.navigation')
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
    </div>
    @include('admin.tools.include.modals')
@endsection
