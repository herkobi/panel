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
                            <button class="nav-link rounded-0 border-0 text-black" id="permissions-tab" data-bs-toggle="tab"
                                data-bs-target="#permissions-tab-pane" type="button" role="tab"
                                aria-controls="permissions-tab-pane" aria-selected="false"><i
                                    class="ri-fingerprint-line"></i>
                                Tanımlı İzinler</button>
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
                        <div class="tab-pane fade" id="permissions-tab-pane" role="tabpanel"
                            aria-labelledby="permissions-tab" tabindex="0">
                            <div class="card rounded-0 shadow-sm border-0 mb-3">
                                <div class="card-header border-0 bg-white pt-3 pb-0">
                                    <h4 class="card-title">Tanımlı İzinler</h4>
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
                                                            @if (in_array($permissionId, $rolePermissions))
                                                                <input
                                                                    class="form-check-input rounded-0 shadow-none group-{{ Str::slug('-', $key) }}-permissions"
                                                                    type="checkbox"
                                                                    id="role-permission-{{ $permissionId }}"
                                                                    name="permission[]" value="{{ $permissionId }}"
                                                                    checked readonly>
                                                            @endif
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
                @hasrole('Super Admin')
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Durum</h4>
                        </div>
                        @if (!$user->hasVerifiedEmail())
                            <div class="card-body">
                                <div class="text-center">
                                    <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                        onclick="emailVerify()">E-posta Onay Linkini Tekrar Gönder</button>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                @foreach (UserStatus::cases() as $userStatus)
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="radio" name="status"
                                            value="{{ $userStatus->value }}" id="user-status-{{ $userStatus->value }}"
                                            onclick="checkStatus(this)"
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
                        @endif
                    </div>
                @endhasrole
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">Kullanıcı İşlemleri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($user->status == UserStatus::ACTIVE)
                            <div class="mb-2 border-bottom pb-2">
                                <button type="button" class="btn btn-text p-0 rounded-0 shadow-none"
                                    onclick="newPassword()">Şifre Yenileme Linki Gönder</button>
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
                <form action="{{ route('panel.admin.change.email', $user->id) }}" method="POST" id="change-email">
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
@endsection

@section('js')
    <script>
        var tagIds = [];
        var status;

        window.addEventListener('load', function() {
            var checkboxes = document.querySelectorAll('.tag[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    tagIds.push(checkbox.value);
                }
            });
        });

        function checkTag(element) {
            const value = element.value;
            const isChecked = element.checked;
            if (isChecked) {
                tagIds.push(value)
            } else {
                tagIds = tagIds.filter(item => item !== value)
            }
        }

        function checkStatus(element) {
            const value = element.value;
            const isChecked = element.checked;
            if (isChecked) {
                status = value
            }
        }

        function sendAjaxRequest(urlToSend, datas, message, reload) {

            if (reload === 'yes') {
                var reload = location.reload();
            } else {
                var reload = '';
            }

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success me-1 rounded-0 shadow-none',
                    cancelButton: 'btn btn-danger ms-1 rounded-0 shadow-none'
                },
                buttonsStyling: false
            })

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
                success: function(data) {
                    if (data.status == 'success') {
                        swalWithBootstrapButtons.fire({
                            icon: 'success',
                            title: 'Başarılı',
                            text: message
                        })

                        reload
                    }
                },
                error: function(data) {
                    swalWithBootstrapButtons.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: data
                    })
                }
            });

        }

        function newPassword() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success me-1 rounded-0 shadow-none',
                    cancelButton: 'btn btn-danger ms-1 rounded-0 shadow-none'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Şifre Yenile?',
                text: "Kullanıcı için şifre yenileme linki göndermek istiyor musunuz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, gönder.'
            }).then((result) => {
                if (result.isConfirmed) {

                    var datas = '';

                    sendAjaxRequest('{{ route('panel.user.password.reset', $user->id) }}', datas,
                        'Şifre yenileme linki gönderildi', 'no');
                }
            });
        }

        function emailVerify() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success me-1 rounded-0 shadow-none',
                    cancelButton: 'btn btn-danger ms-1 rounded-0 shadow-none'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'E-posta Onayı',
                text: "Kullanıcının e-posta adresini onaylaması için tekrar link göndermek istiyor musunuz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, gönder.'
            }).then((result) => {
                if (result.isConfirmed) {

                    var datas = '';

                    sendAjaxRequest('{{ route('panel.user.email.verify', $user->id) }}', datas,
                        'E-posta adresi onaylama linki gönderildi', 'no');
                }
            });
        }

        function statusAjax() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success me-1 rounded-0 shadow-none',
                    cancelButton: 'btn btn-danger ms-1 rounded-0 shadow-none'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Durum Güncelle',
                text: "Kullanıcı durumunu güncellemek istiyor musunuz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, gönder.'
            }).then((result) => {
                if (result.isConfirmed) {
                    sendAjaxRequest('{{ route('panel.user.update.status', $user->id) }}', status,
                        'Kullanıcı durumu başarılı bir şekilde güncellendi', 'yes');
                }
            });
        }

        function tagAjax() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success me-1 rounded-0 shadow-none',
                    cancelButton: 'btn btn-danger ms-1 rounded-0 shadow-none'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Etiket Arama',
                text: "Kullanıcıya etiket atamak istiyor musunuz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, gönder.'
            }).then((result) => {
                if (result.isConfirmed) {
                    sendAjaxRequest('{{ route('panel.user.synctags', $user->id) }}', tagIds,
                        'Kullanıcıya etiket atama işlemi başarılı', 'yes');

                }
            });
        }
    </script>
@endsection
