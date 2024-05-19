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
                            <h1 class="card-title">{{ $user->name . ' ' . $user->surname }} Oturum Kayıtları</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>İşlem</th>
                                        <th>E-posta Adresi</th>
                                        <th>IP Adresi</th>
                                        <th>Cihaz Bilgisi</th>
                                        <th>Bağlam</th>
                                        <th>İşlem Tarihi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($authLogs as $authLog)
                                        <tr>
                                            <td>{{ $authLog->event_name }}</td>
                                            <td>{{ $authLog->email }}</td>
                                            <td>{{ $authLog->ip_address }}</td>
                                            <td>{{ $authLog->user_agent }}</td>
                                            <td>{{ $authLog->context }}</td>
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
@endsection
