@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Araçlar',
                    'title' => 'Kullanıcı İşlemleri',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.tools.activities.partials.navigation')
                    @include('admin.tools.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Kullanıcı İşlemleri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-start text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="w-10">İşlem Adı</th>
                                        <th class="w-70">Açıklama</th>
                                        <th class="w-20">İşlem Tarihi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $log)
                                        <tr>
                                            <td>{{ $log->event == 'updated' ? 'Güncelleme' : ($log->event == 'created' ? 'Ekleme' : 'Silme') }}
                                            </td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $activities->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
