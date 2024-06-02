@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => config('panel.title'),
                    'title' => __('admin/accounts/accounts.main.title'),
                ])
                @include('admin.accounts.partials.page-buttons', [
                    'first_button' => __('admin/accounts/accounts.main.button'),
                    'first_link' => 'panel.accounts',
                    'second_button' => __('admin/accounts/accounts.create.button'),
                    'second_link' => 'panel.account.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card mb-3">
                        <div class="card-header d-flex align-items-start justify-content-between">
                            <div class="d-block">
                                <h1 class="card-title">{{ $user->name . ' ' . $user->surname }}</h1>
                                <div>
                                    @if ($user->status->value == 1)
                                        <span
                                            class="badge bg-green text-green-fg">{{ AccountStatus::title($user->status) }}</span>
                                    @else
                                        <span
                                            class="badge bg-red text-red-fg">{{ AccountStatus::title($user->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-primary text-green-fg">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-body">
                            @if (!$user->hasVerifiedEmail())
                                <div class="alert alert-info shadow-none mb-5" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 9v4"></path>
                                                <path
                                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                </path>
                                                <path d="M12 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Bilgilendirme</h4>
                                            <div class="text-secondary">Kullanıcı e-posta adresini onaylamamış.
                                                Kullanıcıya e-posta onay linkini tekrar göndermek için <a href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-verifyEmail">tıklayınız.</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">E-posta Adresi</div>
                                    <div class="datagrid-content">
                                        {!! $user->hasVerifiedEmail() ? $user->email : '<span class="text-danger">' . $user->email . '</span>' !!}
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Hesap Açılma Tarihi</div>
                                    <div class="datagrid-content">{{ $user->created_at }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Hesabı Oluşturun Kişi</div>
                                    <div class="datagrid-content">{{ $user->created_by_name }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Son Oturum Tarihi</div>
                                    <div class="datagrid-content">{{ $user->last_login_at }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Son Oturum IP Adresi</div>
                                    <div class="datagrid-content">{{ $user->last_login_ip }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-user-activity" class="nav-link active" data-bs-toggle="tab"
                                        aria-selected="true" role="tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon me-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 20m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M10 20h-6" />
                                            <path d="M14 20h6" />
                                            <path
                                                d="M12 15l-2 -2h-3a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-3l-2 2z" />
                                            <path d="M9 6h6" />
                                            <path d="M9 9h3" />
                                        </svg>
                                        Kullanıcı İşlemleri
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-roles-permissions" class="nav-link" data-bs-toggle="tab"
                                        aria-selected="false" role="tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon me-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                                            <path d="M4 14l8 -3l8 3" />
                                        </svg>
                                        Yetki ve İzinler
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-auth-logs" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                        role="tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon me-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M8 11m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                                            <path d="M10 11v-2a2 2 0 1 1 4 0v2" />
                                            <path
                                                d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                        </svg>
                                        Oturum Kayıtları
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-user-activity" role="tabpanel">
                                    <h4>Kullanıcı İşlemleri</h4>
                                    <div class="table-responsive">
                                        <table class="table card-table table-start text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="w-10">İşlem Adı</th>
                                                    <th class="w-70">Açıklama</th>
                                                    <th class="w-20">İşlem Tarihi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activities as $log)
                                                    <tr>
                                                        <td>{{ $log->event == 'updated' ? 'Güncelleme' : ($log->event == 'created' ? 'Ekleme' : 'Silme') }}
                                                        </td>
                                                        <td>{{ $log->description }}</td>
                                                        <td>{{ $log->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                                        {{ $activities->links() }}
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-roles-permissions" role="tabpanel">
                                    <h4>Tanımlı Yetki ve İzinler</h4>
                                </div>
                                <div class="tab-pane" id="tabs-auth-logs" role="tabpanel">
                                    <h4>Oturum Kayıtları</h4>
                                    <div class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap datatable">
                                            <thead>
                                                <tr>
                                                    <th>İşlem</th>
                                                    <th>E-posta Adresi</th>
                                                    <th>IP Adresi</th>
                                                    <th>Cihaz Bilgisi</th>
                                                    <th>Bağlam</th>
                                                    <th>İşlem Tarihi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($authLogs as $authLog)
                                                    <tr>
                                                        <td>{{ $authLog->event_name }}</td>
                                                        <td>{{ $authLog->email }}</td>
                                                        <td>{{ $authLog->ip_address }}</td>
                                                        <td>{{ $authLog->user_agent }}</td>
                                                        <td>{{ $authLog->context }}</td>
                                                        <td>{{ $authLog->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                                        {{ $authLogs->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-header py-2">
                            <h3 class="card-title text-small">Kullanıcı Durumu</h3>
                        </div>
                        <div class="card-body">
                            @foreach (AccountStatus::cases() as $userStatus)
                                <div class="form-check">
                                    <input class="form-check-input rounded-0 shadow-none" type="radio" name="status"
                                        value="{{ $userStatus->value }}" id="user-status-{{ $userStatus->value }}"
                                        data-status-name={{ AccountStatus::getTitle($userStatus->value) }}
                                        {{ $user->status->value == $userStatus->value ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="user-status-{{ $userStatus->value }}">{{ AccountStatus::getTitle($userStatus->value) }}
                                        Hesap</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer py-2 text-end">
                            <button type="button" id="changeStatusBtn" class="btn btn-sm btn-success"
                                data-bs-toggle="modal" data-bs-target="#modal-updateStatus">Durumu
                                Güncelle</button>
                        </div>
                    </div>
                    <div class="dropdown-menu panel-dropdown shadow-none">
                        <span class="dropdown-header">Kullanıcı İşlemleri</span>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#modal-changeEmail" title="E-posta Adresini Değiştir">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon dropdown-item-icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 19h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v5.5" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            E-posta Adresini Değiştir
                        </a>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#modal-verifyEmail" title="E-posta Onay Linki Gönder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon dropdown-item-icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M13 19h-8a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v6" />
                                <path d="M3 7l9 6l9 -6" />
                                <path d="M16 22l5 -5" />
                                <path d="M21 21.5v-4.5h-4.5" />
                            </svg>
                            E-posta Onay Linki Gönder
                        </a>
                        @if (!$user->hasVerifiedEmail())
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#modal-checkEmail" title="E-posta Onay Linki Gönder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M11 19h-6a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v6" />
                                    <path d="M3 7l9 6l9 -6" />
                                    <path d="M15 19l2 2l4 -4" />
                                </svg>
                                E-posta Adresini Onayla
                            </a>
                        @endif
                        <div class="dropdown-divider my-0"></div>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#modal-changePassword" title="Şifre Değiştir">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon dropdown-item-icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M12.5 11.5l-4 4l1.5 1.5" />
                                <path d="M12 15l-1.5 -1.5" />
                                <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Şifre Değiştir
                        </a>
                        @if ($user->status == AccountStatus::ACTIVE)
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#modal-resetPassword" title="Şifre Yenileme Linki Gönder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M19 18a3.5 3.5 0 0 0 0 -7h-1c.397 -1.768 -.285 -3.593 -1.788 -4.787c-1.503 -1.193 -3.6 -1.575 -5.5 -1s-3.315 2.019 -3.712 3.787c-2.199 -.088 -4.155 1.326 -4.666 3.373c-.512 2.047 .564 4.154 2.566 5.027" />
                                    <path
                                        d="M8 15m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                                    <path d="M10 15v-2a2 2 0 0 1 3.736 -1" />
                                </svg>
                                Şifre Yenileme Linki Gönder
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-updateStatus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.account.update.status', $user->id) }}" method="POST">
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
                        <div class="text-secondary mb-3">Kullanıcı durumunu değiştirmek üzeresiniz. Bu durumda kullanıcının
                            panele erişimini kısıtlayabilir veya yasaklarsınız.</div>
                        <div class="mb-3">
                            <label for="currentStatus" class="form-label">Kullanıcının Mevcut Durumu</label>
                            <input type="text" name="currentStatus" id="currentStatus" class="form-control"
                                value="{{ AccountStatus::getTitle($user->status->value) }} Hesap" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="selectedStatus" class="form-label">Kullanıcının Yeni Durumu</label>
                            <input type="hidden" name="selectedStatus" id="selectedStatus" class="form-control">
                            <input type="text" id="selectedStatusName" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items center justify-content between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Hesap Durumunu Değiştir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-changeEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kullanıcı Bilgileri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('panel.account.change.email', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                            <div class="alert alert-info shadow-none mb-5" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 9v4"></path>
                                            <path
                                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                            </path>
                                            <path d="M12 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="alert-title">Bilgilendirme</h4>
                                        <div class="text-secondary">Sisteminizde e-posta adreslerinin onay işlemi açıktır.
                                            Yeni girdiğiniz e-posta adresine onaylaması için onay e-postası gönderilecektir.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Yeni E-posta Adresi</label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Yeni E-posta Adresi" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Yeni E-posta Adresi Tekrar</label>
                                    <input type="email" class="form-control" name="email_confirmation"
                                        placeholder="Yeni E-posta Adresi Tekrar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            İptal Et
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            E-posta Adresini Değiştir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-verifyEmail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.account.verify.email', $user->id) }}" method="POST">
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
                        <div class="text-secondary mb-3">Kullanıcı e-posta adresini onaylaması için onay
                            e-postası göndermek üzeresiniz.</div>
                        <label for="userVerifyEmail" class="form-label">Kullanıcı e-posta adresi</label>
                        <input type="email" name="email" id="userVerifyEmail" class="form-control"
                            value="{{ $user->email }}" readonly>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items center justify-content between w-100">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-warning ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                E-posta Onay Linki Gönder
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-checkEmail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.account.check.email', $user->id) }}" method="POST">
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
                        <div class="text-secondary mb-3">Kullanıcı e-posta adresini onaylayacaksınız.</div>
                        <label for="userUnverifedEmail" class="form-label">Kullanıcı e-posta adresi</label>
                        <input type="email" name="email" id="userUnverifedEmail" class="form-control"
                            value="{{ $user->email }}" readonly>
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
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                E-posta Adresini Onayla
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-changePassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.account.change.password', $user->id) }}" method="POST">
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
                        <div class="text-secondary mb-3">Kullanıcı şifresini değiştirmek üzeresiniz. Kullanıcıya yeni şifre
                            ile bilgi e-postası gönderilecektir.
                        </div>
                        <fieldset id="passwordArea" class="form-fieldset">
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="col-form-label required">Şifre</label>
                                    <button type="button" onclick="generatePassword()"
                                        class="btn btn-sm btn-link link-secondary randompassword rounded-none shadow-none">Şifre
                                        Oluştur</button>
                                </div>
                                <div class="input-group input-group-flat">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Şifreniz" autocomplete="off">
                                    <span class="input-group-text" onclick="password_show_hide();"
                                        data-bs-toggle="tooltip" aria-label="Şifreyi Göster"
                                        data-bs-original-title="Şifreyi Göster">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye showpassword pointer">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off hidepassword pointer d-none">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                            <path
                                                d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </span>
                                </div>
                                <small class="form-hint">Kullanıcı şifresini giriniz</small>
                                @error('password')
                                    <div class="invalid-feedback" role="alert">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="col-form-label required">Şifre Onay</label>
                                </div>
                                <div class="input-group input-group-flat">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Şifreyi Tekrar Giriniz" autocomplete="off">
                                    <span class="input-group-text" onclick="password_conf_show_hide();"
                                        data-bs-toggle="tooltip" aria-label="Şifreyi Göster"
                                        data-bs-original-title="Şifreyi Göster">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye showpassword_conf pointer">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off hidepassword_conf pointer d-none">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                            <path
                                                d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </span>
                                </div>
                                <small class="form-hint">Kullanıcı şifresini tekrar giriniz</small>
                                @error('password_confirmation')
                                    <div class="invalid-feedback" role="alert">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </fieldset>
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
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Kullanıcı Şifresini Değiştir
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-resetPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <form action="{{ route('panel.account.reset.password', $user->id) }}" method="POST">
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
                        <div class="text-secondary mb-3">Kullanıcı şifresini yenilemesi için yenileme e-postası gönder.
                        </div>
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
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Şifre Yenileme Linki Gönder
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        window.onload = function() {
            generatePassword();
        };

        const myModalEl = document.getElementById('modal-updateStatus');
        const modalStatusInput = document.getElementById('selectedStatus');
        const modalLabelInput = document.getElementById('selectedStatusName');
        const radioInputs = document.querySelectorAll('input[name="status"]');

        myModalEl.addEventListener('show.bs.modal', function() {
            let selectedStatusValue = '';
            let selectedStatusLabel = '';
            radioInputs.forEach(input => {
                if (input.checked) {
                    selectedStatusValue = input.value;
                    selectedStatusLabel = input.nextElementSibling.textContent.trim();
                }
            });
            modalStatusInput.value = selectedStatusValue;
            modalLabelInput.value = selectedStatusLabel;
        });

        /*
         * Şifre Oluşturucu
         * Şifre değiştirme alanında otomatik şifre oluşturur
         */
        function generatePassword() {
            var length = 16; // Şifre uzunluğu
            var charset =
                "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+?><:{}[]"; // Karakter dizisi
            var randPassword = "";

            // En az bir adet sembol, büyük harf, küçük harf ve rakam içermesi için flag'ler
            var hasSymbol = false;
            var hasUpperCase = false;
            var hasLowerCase = false;
            var hasDigit = false;

            // Şifre oluşturulması
            while (randPassword.length < length || !hasSymbol || !hasUpperCase || !hasLowerCase || !hasDigit) {
                // Karakter dizisinden rastgele bir karakter seç
                var randomChar = charset.charAt(Math.floor(Math.random() * charset.length));
                // Şifre karakterlerinin gereksinimlerini kontrol et
                if ("!@#$%^&*()_+?><:{}[]".includes(randomChar)) {
                    hasSymbol = true;
                } else if ("abcdefghijklmnopqrstuvwxyz".includes(randomChar)) {
                    hasLowerCase = true;
                } else if ("ABCDEFGHIJKLMNOPQRSTUVWXYZ".includes(randomChar)) {
                    hasUpperCase = true;
                } else if ("0123456789".includes(randomChar)) {
                    hasDigit = true;
                }
                // Şifreye karakteri ekle
                randPassword += randomChar;
            }

            // Oluşturulan şifreyi input alanına yerleştir
            document.getElementById("password").value = randPassword;
        }
        /*
         * Show/Hide Password
         */
        function password_show_hide() {
            const x = document.getElementById("password");
            const show_eye = document.querySelector(".showpassword");
            const hide_eye = document.querySelector(".hidepassword");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }

        function password_conf_show_hide() {
            const y = document.getElementById("password_confirmation");
            const show_conf_eye = document.querySelector(".showpassword_conf");
            const hide_conf_eye = document.querySelector(".hidepassword_conf");
            hide_conf_eye.classList.remove("d-none");
            if (y.type === "password") {
                y.type = "text";
                show_conf_eye.style.display = "none";
                hide_conf_eye.style.display = "block";
            } else {
                y.type = "password";
                show_conf_eye.style.display = "block";
                hide_conf_eye.style.display = "none";
            }
        }
    </script>
@endsection
