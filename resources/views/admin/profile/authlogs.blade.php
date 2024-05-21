@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Oturum Bilgileri',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profil Bilgileri</h4>
                            <div class="list-group list-group-transparent">
                                @include('admin.profile.partials.navigation')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Oturum Bilgileri</h2>
                            <div class="row mb-5">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="card-title">Aktif Oturumlar</h3>
                                    <button type="button" class="btn btn-sm btn-outline-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-world-off">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5.657 5.615a9 9 0 1 0 12.717 12.739m1.672 -2.322a9 9 0 0 0 -12.066 -12.084" />
                                            <path d="M3.6 9h5.4m4 0h7.4" />
                                            <path d="M3.6 15h11.4m4 0h1.4" />
                                            <path
                                                d="M11.5 3a17.001 17.001 0 0 0 -1.493 3.022m-.847 3.145c-.68 4.027 .1 8.244 2.34 11.833" />
                                            <path
                                                d="M12.5 3a16.982 16.982 0 0 1 2.549 8.005m-.207 3.818a16.979 16.979 0 0 1 -2.342 6.177" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                        <span class="ms-2">Tüm Oturumları Sonlandır</span>
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <ul class="timeline browser row">
                                        @foreach ($sessions as $log)
                                            <li class="timeline-event col-lg-6">
                                                <div class="card timeline-event-card ms-0">
                                                    <div class="card-body d-flex align-items-start justify-content-start">
                                                        <div class="avatar bg-muted-lt text-azure-fg me-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-devices">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M13 9a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1v-10z" />
                                                                <path
                                                                    d="M18 8v-3a1 1 0 0 0 -1 -1h-13a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h9" />
                                                                <path d="M16 9h2" />
                                                            </svg>
                                                        </div>
                                                        <div class="d-flex align-items-start justify-content-between w-100">
                                                            <div class="text-secondary">
                                                                <div class="d-block">
                                                                    <span class="fw-bold">İşletim Sistemi:</span>
                                                                    {{ $log->device['platform'] }}
                                                                </div>
                                                                <div class="d-block">
                                                                    <span class="fw-bold">Cihaz:</span>
                                                                    {{ $log->device['desktop']
                                                                        ? 'Masaüstü Bilgisayar'
                                                                        : ($log->device['tablet']
                                                                            ? 'Tablet Bilgisayar'
                                                                            : 'Akıllı Telefon') }}
                                                                </div>
                                                                <div class="d-block">
                                                                    <span class="fw-bold">Tarayıcı:</span>
                                                                    {{ $log->device['browser'] }}
                                                                </div>
                                                                <div class="d-block">
                                                                    <span class="fw-bold">IP Adresi:</span>
                                                                    {{ $log->ip_address }}
                                                                </div>
                                                            </div>
                                                            <div class="text-secondary">
                                                                {{ $log->last_active }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{ $logs->links() }}
                                </div>
                            </div>
                            <div class="row">
                                <h3 class="card-title">Oturum Kayıtları</h3>
                                <div class="col-md-12">
                                    <ul class="timeline">
                                        @foreach ($logs as $log)
                                            <li class="timeline-event">
                                                <div class="timeline-event-icon bg-twitter-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                </div>
                                                <div class="card timeline-event-card">
                                                    <div
                                                        class="card-body d-flex align-items-center justify-content-between">
                                                        <div class="text-secondary">
                                                            <div class="d-block">
                                                                <span class="fw-bold">IP Adresi:</span>
                                                                {{ $log->ip_address }}
                                                            </div>
                                                            <div class="d-block">
                                                                <span class="fw-bold">Cihaz:</span> {{ $log->user_agent }}
                                                            </div>
                                                        </div>
                                                        <div class="text-secondary">
                                                            {{ $log->created_at }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{ $logs->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
