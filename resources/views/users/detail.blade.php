@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', [
        'title' => $user->name,
        'status' => UserStatus::title($user->status),
    ])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-9">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Hesap Bilgileri</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <dl class="row">
                                    <dt class="col-sm-4">Ad Soyad</dt>
                                    <dd class="col-sm-8">Bülent Sakarya</dd>
                                    <dt class="col-sm-4">E-posta Adresi</dt>
                                    <dd class="col-sm-8">sakarya.bulent@gmail.com</dd>
                                    <dt class="col-sm-4">Kullanılan Paket</dt>
                                    <dd class="col-sm-8">Profesyonel - <small>Aylık</small></dd>
                                    <dt class="col-sm-4">Üyelik Tarihi</dt>
                                    <dd class="col-sm-8">15.02.2022 14:25:45</dd>
                                    <dt class="col-sm-4">Ödeme Tutarı</dt>
                                    <dd class="col-sm-8">₺ 1.255,00</dd>
                                    <dt class="col-sm-4">Sonraki Ödeme</dt>
                                    <dd class="col-sm-8">25.05.2023</dd>
                                </dl>
                            </div>
                            <div class="col-md-6 mb-3">
                                <dl class="row">
                                    <dt class="col-sm-4">Fatura Adı</dt>
                                    <dd class="col-sm-8">Herkobi Dijital Çözümler Yazılım San. ve Tic. A.Ş.</dd>
                                    <dt class="col-sm-4">Fatura Adresi</dt>
                                    <dd class="col-sm-8">Alacamescit Mah. Bayathane Cd. Çamoğlu İşhanı K:3/301 Osmangazi /
                                        Bursa</dd>
                                    <dt class="col-sm-4">TC/Vergi No/Daire</dt>
                                    <dd class="col-sm-8">62908416512 - Osmangazi</dd>
                                    <dt class="col-sm-4">Ticari Sicil No</dt>
                                    <dd class="col-sm-8">1625024</dd>
                                    <dt class="col-sm-4">Mersis No</dt>
                                    <dd class="col-sm-8">1625024546548791321</dd>
                                    <dt class="col-sm-4">Kep E-posta</dt>
                                    <dd class="col-sm-8">iletisim@herkobi.com</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Müşteri Aktiviteleri</h4>
                    </div>
                    <div class="card-body">
                        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl bg-success"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content border-bottom bounce-in">
                                        <h4 class="timeline-title">Başarılı Ödeme</h4>
                                        <p>Paket ödemesi başarılı bir şekilde gerçekleşti</p>
                                        <span class="vertical-timeline-element-date">12 Ağustos 2022<br>15:30:45</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl bg-warning"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content border-bottom bounce-in">
                                        <h4 class="timeline-title">Başarısız Ödeme</h4>
                                        <p>Paket ödemesi gerçekleşmedi</p>
                                        <span class="vertical-timeline-element-date">07 Temmuz 2023<br>15:30:45</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl bg-danger"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content border-bottom bounce-in">
                                        <h4 class="timeline-title">Paket Değişimi</h4>
                                        <p>Standart aylık paketten standart yıllık pakete geçiş gerçekleşti.</p>
                                        <span class="vertical-timeline-element-date">27 Aralık 2023<br>15:30:45</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <form action="" method="post">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Durum</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input rounded-0 shadow-none" type="radio" name="status[]"
                                    value="active" id="statusActive" disabled checked>
                                <label class="form-check-label" for="statusActive">Aktif Hesaplar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input rounded-0 shadow-none" type="radio" name="status[]"
                                    value="passive" id="statusPassive">
                                <label class="form-check-label" for="statusPassive">Pasif Hesaplar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input rounded-0 shadow-none" type="radio" name="status[]"
                                    value="closed" id="statusClosed">
                                <label class="form-check-label" for="statusClosed">Kapalı Hesaplar</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm rounded-0 shadow-none">Durum
                                Değiştir</button>
                        </div>
                    </form>
                </div>
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <form action="" method="post">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Kategoriler</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                            name="category[]" value="kategori-adi" id="categoryField">
                                        <label class="form-check-label" for="categoryField">Kategori Adı</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                            name="category[]" value="kategori-adi" id="categoryField">
                                        <label class="form-check-label" for="categoryField">Kategori Adı</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                            name="category[]" value="kategori-adi" id="categoryField">
                                        <label class="form-check-label" for="categoryField">Kategori Adı</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                            name="category[]" value="kategori-adi" id="categoryField">
                                        <label class="form-check-label" for="categoryField">Kategori Adı</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                            name="category[]" value="kategori-adi" id="categoryField" checked>
                                        <label class="form-check-label" for="categoryField">Kategori Adı</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm rounded-0 shadow-none">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
