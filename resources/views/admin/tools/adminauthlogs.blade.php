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
                            <h1 class="card-title">Yöneticilere Ait Oturum Kayıtları</h1>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
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
