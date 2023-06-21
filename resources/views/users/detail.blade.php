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
                                                <h5 class="timeline-title">Başarılı Ödeme</h5>
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
                                                <h5 class="timeline-title">Başarısız Ödeme</h5>
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
                                                <h5 class="timeline-title">Paket Değişimi</h5>
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
                                            @foreach ($basePermissions as $key => $permissions)
                                            <div class="row mb-5">
                                                <div class="col-md-12 mb-2">
                                                    <div class="d-flex align-items-center justify-content-between border-bottom">
                                                        <h4>{{ $key }}</h4>
                                                    </div>
                                                </div>
                                                <div id="{{'group-'. Str::slug('-', $key) }}" class="row">
                                                    @foreach ($permissions as $permissionId => $permission)
                                                    <div class="col-md-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input rounded-0 shadow-none group-{{ Str::slug('-', $key) }}-permissions" type="checkbox" id="role-permission-{{ $permissionId }}" name="permission[]" value="{{ $permissionId }}" {{ in_array($permissionId, $rolePermissions) ? "checked" : ""}}>
                                                            <label class="form-check-label" for="role-permission-{{ $permissionId }}">{{ $permission }}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
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
                                <div class="col-md-8">
                                    @if (!$user->hasVerifiedEmail())
                                        E-posta Onay Bekliyor
                                    @else
                                        {{ $user->status->title() }}
                                    @endif
                                </div>
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
                                <label class="form-label col-md-5 fw-semibold mb-0" for="user-status">Şifre
                                    Yenileme</label>
                                <div class="col-md-7">
                                    <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                        onclick="event.preventDefault(); document.getElementById('password-reset-form').submit()">Şifre
                                        Yenileme Linki Gönder</button>
                                </div>
                            </div>
                        </div>
                        @if (!$user->hasVerifiedEmail())
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-5 fw-semibold mb-0" for="user-status">E-posta
                                        Onayı</label>
                                    <div class="col-md-7">
                                        <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                            onclick="event.preventDefault(); document.getElementById('email-verify-form').submit()">E-posta
                                            Onay Linki Gönder</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-5 fw-semibold mb-0" for="change-email">E-posta
                                    Değişimi</label>
                                <div class="col-md-7"><button class="btn text p-0" data-bs-toggle="modal"
                                        data-bs-target="#changeEmail">E-posta Adresini Değiştir</button></div>
                            </div>
                        </div>
                        @if ($user->hasVerifiedEmail())
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-5 fw-semibold mb-0" for="user-status">Durum</label>
                                    <div class="col-md-7">Kullanıcı Durumunu Değiştir</div>
                                </div>
                            </div>
                        @endif
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
    <div class="modal fade" id="changeEmail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="changeEmailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 shadow-none bg-white">
                <form action="{{ route('panel.user.change.email', $user->id) }}" method="POST" id="change-email">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changeEmailLabel">E-posta Adresini Güncelle</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-5 fw-semibold mb-0" for="user-default-email">Güncel
                                    E-posta Adresi</label>
                                <div class="col-md-7">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row">
                                <label class="form-label col-md-5 fw-semibold mb-0" for="user-new-email">Yeni E-posta
                                    Adresi</label>
                                <div class="col-md-7">
                                    <input type="email" class="form-control form-control-sm rounded-0 shadow-none"
                                        name="email" value="{{ $user->email ? old('email') : $user->email }}" required
                                        autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm rounded-0 shadow-none"
                            data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 shadow-none">Değiştir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form action="{{ route('panel.user.password.reset', $user->id) }}" method="POST" id="password-reset-form">
        @csrf
    </form>
    <form action="{{ route('panel.user.email.verify', $user->id) }}" method="POST" id="email-verify-form">
        @csrf
    </form>
@endsection
