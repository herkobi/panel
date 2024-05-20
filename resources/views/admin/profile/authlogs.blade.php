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
                            <div class="row">
                                <h3 class="card-title">Tarayıcı Oturumları</h3>
                            </div>
                            <div class="row">
                                <h3 class="card-title">Son Oturumlar</h3>
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
