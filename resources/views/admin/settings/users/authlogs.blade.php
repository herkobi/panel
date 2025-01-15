@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    @include('admin.settings.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.users.include.usercard')
                    @include('admin.settings.users.include.usermenu')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('panel.settings.user.detail', $user->id) }}"
                                        title="Kullanıcı İşlemleri">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-activity me-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2" />
                                        </svg>
                                        Kullanıcı İşlemleri
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="true"
                                        href="{{ route('panel.settings.user.authlogs', $user->id) }}"
                                        title="Oturum Kayıtları">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-bounding-box me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5" />
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        </svg>
                                        Oturum Kayıtları
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="w-20">Oturum Tarihi</th>
                                            <th class="w-20">Cihaz Bilgisi</th>
                                            <th class="w-20">İşletim Sistemi</th>
                                            <th class="w-20">Tarayıcı Bilgisi</th>
                                            <th class="w-20">Geçen Süre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $authLog)
                                            @php
                                                $agentData = json_decode($log->user->agent, true);
                                                $userAgent = new Jenssegers\Agent\Agent();

                                                // JSON verisinden cihaz bilgilerini alın
                                                $device = $agentData['device'] ?? null;
                                                $os = $agentData['os'] ?? null;
                                                $os_version = $agentData['os_version'] ?? null;
                                                $browser = $agentData['browser'] ?? null;
                                                $browser_version = $agentData['browser_version'] ?? null;
                                                $language = $agentData['language'] ?? null;

                                                // Jenssegers/agent paketiyle cihaz türünü belirleyin
                                                $userAgent->setUserAgent($device);

                                                // Cihaz türüne göre farklı çıktılar yazdırın
                                                $deviceType = 'Bilinmeyen';
                                                if ($userAgent->isDesktop()) {
                                                    $deviceType = 'Masaüstü Bilgisayar';
                                                } elseif ($userAgent->isMobile()) {
                                                    $deviceType = 'Akıllı Cep Telefonu';
                                                } elseif ($userAgent->isTablet()) {
                                                    $deviceType = 'Tablet Bilgisayar';
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $authLog->user->last_login_at }}<br>{{ $authLog->user->last_login_ip }}
                                                </td>
                                                <td>{{ $deviceType }}</td>
                                                <td>{{ $os . ' ' . $os_version }}</td>
                                                <td>{{ $browser . ' ' . $browser_version }} - {{ $language }}</td>
                                                <td>{{ Carbon::parse($authLog->user->last_login_at)->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.settings.users.include.modals')
@endsection
