@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Profil Bilgileri',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                    @include('admin.profile.include.navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Oturum Kayıtları</h1>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>İşlem</th>
                                    <th>IP Adresi</th>
                                    <th>Cihaz Bilgisi</th>
                                    <th>İşlem Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($authLogs as $authLog)
                                    <tr>
                                        <td>{{ $authLog->event_name }}</td>
                                        <td>{{ $authLog->ip_address }}</td>
                                        <td>{{ $authLog->user_agent }}</td>
                                        <td>{{ $authLog->created_at }}</td>
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
