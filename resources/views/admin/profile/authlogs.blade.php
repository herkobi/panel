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
                            <h2 class="profile-section-title border-bottom fw-normal pb-3 mb-5">Oturum Kayıtları</h2>
                            <ul class="timeline">
                                @foreach ($logs as $log)
                                    <li class="timeline-event">
                                        <div class="timeline-event-icon bg-twitter-lt">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-browser-check">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4 4m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z" />
                                                <path d="M4 8h16" />
                                                <path d="M8 4v4" />
                                                <path d="M9.5 14.5l1.5 1.5l3 -3" />
                                            </svg>
                                        </div>
                                        <div class="card timeline-event-card">
                                            <div class="card-body d-flex align-items-center justify-content-between">
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
@endsection
