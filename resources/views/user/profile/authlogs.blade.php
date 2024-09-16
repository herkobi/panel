@extends('layouts.app')
@section('content')
    <div class="container h-100">
        @include('user.include.header', [
            'title' => 'Profil Bilgileri',
        ])
        <div class="page-content flex-grow-1 d-flex flex-column shadow-sm h-100">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="page-menu rounded-2">
                                @include('user.profile.include.navigation')
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="border-bottom mb-4 pb-3">Oturum Kayıtları</h2>
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
        </div>
    </div>
@endsection
