@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', [
        'title' => $user->name,
        'status' => !$user->hasVerifiedEmail() ? 'E-posta Onayı Bekliyor' : UserStatus::title($user->status),
    ])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-9">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Kullanıcı Bilgileri</h4>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3 mb-2">Yetki</dt>
                            <dd class="col-sm-9">
                                @foreach ($user->roles as $role)
                                    <span class="me-2 mb-2">{{ $role->name }}</span>
                                @endforeach
                            </dd>
                            <dt class="col-sm-3 mb-2">Ad Soyad</dt>
                            <dd class="col-sm-9">{{ $user->name }}</dd>
                            <dt class="col-sm-3 mb-2">E-posta Adresi</dt>
                            <dd class="col-sm-9">{{ $user->email }}</dd>
                            <dt class="col-sm-3 mb-2">Üyelik Tarihi</dt>
                            <dd class="col-sm-9">{{ $user->created_at }}</dd>
                            <dt class="col-sm-3 mb-2">Son Oturum Tarihi</dt>
                            <dd class="col-sm-9">{{ $user->last_login_at }}</dd>
                            <dt class="col-sm-3 mb-2">Son Oturum IP Adresi</dt>
                            <dd class="col-sm-9">{{ $user->last_login_ip }}</dd>
                            <dt class="col-sm-3 mb-2">Kayıt Eden</dt>
                            <dd class="col-sm-9">{{ $user->created_by_name }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="user-content-tab-menus">
                    <ul class="nav nav-tabs rounded-0 bg-white border-0" id="userTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-0 border-0 text-black active" id="activity-tab"
                                data-bs-toggle="tab" data-bs-target="#activity-tab-pane" type="button" role="tab"
                                aria-controls="activity-tab-pane" aria-selected="true"><i class="ri-history-line"></i> Hesap
                                Hareketleri</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-0 border-0 text-black" id="auth-tab" data-bs-toggle="tab"
                                data-bs-target="#auth-tab-pane" type="button" role="tab" aria-controls="auth-tab-pane"
                                aria-selected="false"><i class="ri-user-follow-line"></i> Oturum Kayıtları</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-0 border-0 text-black" id="account-tab" data-bs-toggle="tab"
                                data-bs-target="#account-tab-pane" type="button" role="tab"
                                aria-controls="account-tab-pane" aria-selected="false"><i
                                    class="ri-account-pin-box-line"></i> Hesap Bilgileri</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-0 border-0 text-black" id="permissions-tab" data-bs-toggle="tab"
                                data-bs-target="#permissions-tab-pane" type="button" role="tab"
                                aria-controls="permissions-tab-pane" aria-selected="false"><i
                                    class="ri-fingerprint-line"></i>
                                Özel İzinler</button>
                        </li>
                    </ul>
                </div>
                <div class="user-content-tab-contents">
                    <div class="tab-content" id="userTabContent">
                        <div class="tab-pane fade show active" id="activity-tab-pane" role="tabpanel"
                            aria-labelledby="activity-tab" tabindex="0">
                            <div class="card rounded-0 shadow-sm border-0 mb-3">
                                <div class="card-header border-0 bg-white pt-3 pb-0">
                                    <h4 class="card-title">Hesap Hareketleri</h4>
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="auth-tab-pane" role="tabpanel" aria-labelledby="auth-tab"
                            tabindex="0">
                            <div class="card rounded-0 shadow-sm border-0 mb-3">
                                <div class="card-header border-0 bg-white pt-3 pb-0">
                                    <h4 class="card-title">Oturum Kayıtları</h4>
                                </div>
                                <div class="card-body">
                                    <div
                                        class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-tab-pane" role="tabpanel" aria-labelledby="account-tab"
                            tabindex="0">
                            <div class="card rounded-0 shadow-sm border-0 mb-3">
                                <div class="card-header border-0 bg-white pt-3 pb-0">
                                    <h4 class="card-title">Hesap Bilgileri</h4>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-4">Fatura Adı</dt>
                                        <dd class="col-sm-8">Herkobi Dijital Çözümler Yazılım San. ve Tic. A.Ş.</dd>
                                        <dt class="col-sm-4">Fatura Adresi</dt>
                                        <dd class="col-sm-8">Alacamescit Mah. Bayathane Cd. Çamoğlu İşhanı K:3/301
                                            Osmangazi / Bursa</dd>
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
                        <div class="tab-pane fade" id="permissions-tab-pane" role="tabpanel"
                            aria-labelledby="permissions-tab" tabindex="0">
                            <div class="card rounded-0 shadow-sm border-0 mb-3">
                                <div class="card-header border-0 bg-white pt-3 pb-0">
                                    <h4 class="card-title">Özel İzinler</h4>
                                </div>
                                <div class="card-body">
                                    @foreach ($basePermissions as $key => $permissions)
                                        <div class="row mb-5">
                                            <div class="col-md-12 mb-2">
                                                <div
                                                    class="d-flex align-items-center justify-content-between border-bottom">
                                                    <h4>{{ $key }}</h4>
                                                </div>
                                            </div>
                                            <div id="{{ 'group-' . Str::slug('-', $key) }}" class="row">
                                                @foreach ($permissions as $permissionId => $permission)
                                                    <div class="col-md-3">
                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input rounded-0 shadow-none group-{{ Str::slug('-', $key) }}-permissions"
                                                                type="checkbox" id="role-permission-{{ $permissionId }}"
                                                                name="permission[]" value="{{ $permissionId }}"
                                                                {{ in_array($permissionId, $rolePermissions) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="role-permission-{{ $permissionId }}">{{ $permission }}</label>
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
            <div class="col-md-3">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Durum</h4>
                    </div>
                    @if (!$user->hasVerifiedEmail())
                        <div class="card-body">
                            <div class="text-center">
                                <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                    onclick="event.preventDefault(); document.getElementById('email-verify-form').submit()">E-posta
                                    Onay Linkini Tekrar Gönder</button>
                            </div>
                        </div>
                    @else
                        <form action="" method="post">
                            @csrf
                            <div class="card-body">
                                @foreach (UserStatus::cases() as $userStatus)
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="radio"
                                            name="status" value="{{ $userStatus->value }}"
                                            id="user-status-{{ $userStatus->value }}" onclick="checkStatus(this)"
                                            {{ $user->status->value == $userStatus->value ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="user-status-{{ $userStatus->value }}">{{ UserStatus::getTitle($userStatus->value) }}
                                            Hesap</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <button type="button" id="update-user-status" onclick="statusAjax()"
                                    class="btn btn-primary btn-sm rounded-0 shadow-none">Durum
                                    Değiştir</button>
                            </div>
                        </form>
                    @endif
                </div>
                @if ($tags->count() > 0)
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <form action="" method="post">
                            @csrf
                            <div class="card-header border-0 bg-white pt-3 pb-0">
                                <h4 class="card-title mb-0">Etiketler</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($tags as $tag)
                                        <li class="list-group-item bg-white">
                                            <div class="form-check">
                                                <input id="user-tag-select-{{ $tag->id }}"
                                                    class="form-check-input rounded-0 shadow-none tag" type="checkbox"
                                                    onclick="checkTag(this)" name="tag[]" value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, $selectedTag) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="user-tag-select-{{ $tag->id }}">{{ $tag->name }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer">
                                <button type="button" id="update-user-tag" onclick="tagAjax()"
                                    class="btn btn-primary btn-sm rounded-0 shadow-none">Güncelle</button>
                            </div>
                        </form>
                    </div>
                @endif
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">Kullanıcı İşlemleri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-2 border-bottom pb-2">
                            <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                onclick="event.preventDefault(); document.getElementById('password-reset-form').submit()">Şifre
                                Yenileme Linki Gönder</button>
                        </div>
                        @if (!$user->hasVerifiedEmail())
                            <div class="mb-2 border-bottom pb-2">
                                <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                    onclick="event.preventDefault(); document.getElementById('email-verify-form').submit()">E-posta
                                    Onay Linki Gönder</button>
                            </div>
                        @endif
                        <div class="mb-2 border-bottom pb-2">
                            <button class="btn text p-0" data-bs-toggle="modal" data-bs-target="#changeEmail">E-posta
                                Adresini Değiştir</button>
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

@section('js')
    <script>
        var tagIds = [];
        var status;

        function checkTag(element) {
            const value = element.value;
            const isChecked = element.checked;
            if (isChecked) {
                tagIds.push(value)
            } else {
                tagIds = tagIds.filter(item => item !== value)
            }
        }

        // window.addEventListener('load', function() {
        //     var checkboxes = document.querySelectorAll('.tag[type="checkbox"]');
        //     checkboxes.forEach(function(checkbox) {
        //         if (checkbox.checked) {
        //             tagIds.push(checkbox.value);
        //         }
        //         checkbox.addEventListener('change', function() {
        //             if (this.checked) {
        //                 tagIds.push(this.value);
        //             } else {
        //                 var index = tagIds.indexOf(this.value);
        //                 if (index !== -1) {
        //                     tagIds.splice(index, 1);
        //                 }
        //             }
        //         });
        //         console.log(tagIds);
        //     });
        // });


        // TODO: Sayfa yüklendiğinde seçili gelenler de tagIds içine alınacak

        function checkStatus(element) {
            const value = element.value;
            const isChecked = element.checked;
            if (isChecked) {
                status = value
            }
        }

        function sendAjaxRequest(urlToSend, datas) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlToSend,
                data: {
                    user_id: {{ $user->id }},
                    ids: datas
                },
                success: function(result) {
                    window.location.reload();
                },
                error: function(result) {
                    alert('error');
                }
            });
        }

        // TODO: data değeri dışardan tüm alanları ile birlikte gönderilecek
        // TODO: success ve error değerleri için dinamik içerikler gelecek
        // TODO: Bu ajax fonksiyonu globale taşınacak. her yerden kullanılacak.

        function statusAjax() {
            sendAjaxRequest('{{ route('panel.user.update.status') }}', status);
        }

        function tagAjax() {
            sendAjaxRequest('{{ route('panel.user.synctags') }}', tagIds);
        }
    </script>
@endsection
