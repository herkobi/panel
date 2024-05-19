@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Araçlar',
                    'title' => 'Oturum Kayıtları',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.tools.authlogs.partials.navigation')
                    @include('admin.tools.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Hesap Oturum Kayıtları</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-start text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="w-25">Kulanıcı Ad Soyad</th>
                                        <th class="w-20">Oturum Tarihi</th>
                                        <th class="w-15">Oturum IP Adresi</th>
                                        <th class="w-15">Geçen Süre</th>
                                        <th class="w-15">Cihaz Bilgisi</th>
                                        <th class="w-10"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        @php
                                            $agentData = json_decode($log->agent, true);
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
                                                <div class="d-block fw-bold">{{ $log->name . ' ' . $log->surname }}</div>
                                                <span class="badge bg-indigo-lt">{{ $log->title }}</span>
                                            </td>
                                            <td>{{ $log->last_login_at }}</td>
                                            <td>{{ $log->last_login_ip }}</td>
                                            <td>{{ Carbon::parse($log->last_login_at)->diffForHumans() }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm" title="Cihaz Bilgisi"
                                                    data-bs-toggle="popover" data-bs-placement="left" data-bs-html="true"
                                                    data-bs-content="<div class='datagrid'>
                                                        <div class='datagrid-item'>
                                                            <div class='datagrid-title'>Cihaz</div>
                                                            <div class='datagrid-content'>{{ $deviceType }}</div>
                                                        </div>
                                                        <div class='datagrid-item'>
                                                            <div class='datagrid-title'>İşletim Sistemi</div>
                                                            <div class='datagrid-content'>{{ $os . ' ' . $os_version }}</div>
                                                        </div>
                                                        <div class='datagrid-item'>
                                                            <div class='datagrid-title'>Tarayıcı</div>
                                                            <div class='datagrid-content'>
                                                                {{ $browser . ' ' . $browser_version }}</div>
                                                        </div>
                                                        <div class='datagrid-item'>
                                                            <div class='datagrid-title'>Tarayıcı Dili</div>
                                                            <div class='datagrid-content'>{{ $language }}</div>
                                                        </div>
                                                    </div>">Cihaz
                                                    Bilgisi</button>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.tools.logs.detail', $log->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Bilgiler">
                                                    Bilgiler
                                                </a>
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
    </div>
@endsection
