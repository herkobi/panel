@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    @include('admin.tools.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3">
                    @include('admin.tools.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-6">
                            <h2 class="mb-0">Yöneticilere Ait Oturum Kayıtları</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="w-30">Kulanıcı Ad Soyad</th>
                                    <th class="w-30">Oturum Tarihi</th>
                                    <th class="w-15">Geçen Süre</th>
                                    <th class="w-15">Cihaz Bilgisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
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
                                        <td>
                                            <div class="d-block fw-bold">
                                                {{ $log->user->name . ' ' . $log->user->surname }}<br>{{ $log->email }}
                                            </div>
                                        </td>
                                        <td>{{ $log->user->last_login_at }}<br>{{ $log->user->last_login_ip }}</td>
                                        <td>{{ Carbon::parse($log->user->last_login_at)->diffForHumans() }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-dark" title="Cihaz Bilgisi"
                                                data-bs-toggle="popover" data-bs-placement="left" data-bs-html="true"
                                                data-bs-content="<div class='datagrid'>
                                                        <div class='datagrid-item mb-1'>
                                                            <div class='datagrid-title fw-bold w-100'>Cihaz</div>
                                                            <div class='datagrid-content'>{{ $deviceType }}</div>
                                                        </div>
                                                        <div class='datagrid-item mb-1'>
                                                            <div class='datagrid-title fw-bold w-100'>İşletim Sistemi</div>
                                                            <div class='datagrid-content'>{{ $os . ' ' . $os_version }}</div>
                                                        </div>
                                                        <div class='datagrid-item mb-1'>
                                                            <div class='datagrid-title fw-bold w-100'>Tarayıcı</div>
                                                            <div class='datagrid-content'>
                                                                {{ $browser . ' ' . $browser_version }}</div>
                                                        </div>
                                                        <div class='datagrid-item mb-1'>
                                                            <div class='datagrid-title fw-bold w-100'>Tarayıcı Dili</div>
                                                            <div class='datagrid-content'>{{ $language }}</div>
                                                        </div>
                                                    </div>">Cihaz
                                                Bilgisi</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
