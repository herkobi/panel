@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Kullanıcı Bilgileri'])
    <div class="page-content position-relative activity-page mb-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <ul class="nav nav-underline" id="activityTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link pt-0 active" id="activity-tab" data-bs-toggle="tab"
                                    data-bs-target="#activity-tab-pane" type="button" role="tab"
                                    aria-controls="activity-tab-pane" aria-selected="true">Kullanıcı Hareketleri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pt-0 text-secondary" id="role-tab" data-bs-toggle="tab"
                                    data-bs-target="#role-tab-pane" type="button" role="tab"
                                    aria-controls="role-tab-pane" aria-selected="false">Yetki ve İzinler</a>
                            </li>
                        </ul>
                        <div id="activityTabContent" class="tab-content user-activity">
                            <div class="tab-pane fade show active" id="activity-tab-pane" role="tabpanel"
                                aria-labelledby="activity-tab" tabindex="0">
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl bg-success"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content border-bottom bounce-in">
                                                <h4 class="timeline-title">Başarılı Ödeme</h4>
                                                <p>Paket ödemesi başarılı bir şekilde gerçekleşti</p>
                                                <span class="vertical-timeline-element-date">12 Ağustos
                                                    2022<br>15:30:45</span>
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
                                                <span class="vertical-timeline-element-date">07 Temmuz
                                                    2023<br>15:30:45</span>
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
                                                <span class="vertical-timeline-element-date">27 Aralık
                                                    2023<br>15:30:45</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="role-tab-pane" role="tabpanel" aria-labelledby="role-tab"
                                tabindex="0">
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label class="form-label col-md-4 fw-semibold mb-0"
                                            for="user-roles">Yetkiler</label>
                                        <div id="user-roles" class="col-md-7">
                                            <ul class="list-unstyled list-inline mb-0">
                                                @foreach ($user->roles as $role)
                                                    <li>{{ $role->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label class="form-label col-md-4 fw-semibold mb-0" for="user-permissions">Özel
                                            İzinler</label>
                                        <div id="user-permissions" class="col-md-7">
                                            <ul class="list-unstyled list-inline mb-0">
                                                @foreach ($user->permissions as $permission)
                                                    <li>
                                                        <span
                                                            class="d-block fw-semibold">{{ $permission->group->name }}</span>
                                                        {{ $permission->text }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">Genel Bilgiler</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-status">Durum</label>
                                <div class="col-md-8">{{ $user->status->title() }}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-name">Ad Soyad</label>
                                <div class="col-md-8">{{ $user->name }}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-email">E-posta Adresi</label>
                                <div class="col-md-8">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">Kullanıcı İşlemleri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-status">Şifre</label>
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                        onclick="event.preventDefault(); document.getElementById('password-reset-form').submit();">Şifre
                                        Yenileme Linki Gönder</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-status">Durum</label>
                                <div class="col-md-8">Kullanıcı Durumunu Değiştir</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">Hesap ve Oturum Bilgileri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-membership">Üyelik
                                    Tarihi</label>
                                <div class="col-md-8">{{ $user->created_at }}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-lastloginat">Son Oturum
                                    Tarihi</label>
                                <div class="col-md-8">{{ $user->last_login_at }}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-lastloginip">Son Oturum
                                    IP</label>
                                <div class="col-md-8">{{ $user->last_login_ip }}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="user-createdbyname">Kayıt
                                    Eden</label>
                                <div class="col-md-8">{{ $user->created_by_name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('panel.user.password.reset') }}" method="POST" id="password-reset-form">
        @csrf
        <input type="hidden" name="token" value="{{ csrf_token() }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
    </form>
@endsection
