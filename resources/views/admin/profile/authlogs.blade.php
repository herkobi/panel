@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Profil Bilgileri',
    ])
    <div class="page-content mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.profile.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="page-form">
                        <h3 class="form-title border-bottom mb-3 pb-3">Oturum Kayıtları</h3>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>İşlem</th>
                                        <th>IP Adresi</th>
                                        <th>Cihaz Bilgisi</th>
                                        <th>İşlem Tarihi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->authlogs as $log)
                                        <tr>
                                            <td>{{ $log->event_name }}</td>
                                            <td>{{ $log->ip_address }}</td>
                                            <td>{{ $log->user_agent }}</td>
                                            <td>{{ $log->created_at }}</td>
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
