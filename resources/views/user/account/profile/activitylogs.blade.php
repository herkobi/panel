@extends('layouts.app')
@section('content')
    @include('user.include.header', [
        'title' => 'Hesabım',
    ])
    @include('user.account.include.navigation')
    <div class="page-content mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('user.account.profile.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="page-form">
                        <h3 class="form-title border-bottom mb-3 pb-3">İşlem Kayıtları</h3>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="w-20">İşlem Adı</th>
                                        <th class="w-60">İşlem Açıklaması</th>
                                        <th class="w-20">İşlem Tarihi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->activities as $log)
                                        <tr>
                                            <td>{{ $log->message }}</td>
                                            <td>{{ $log->log }}</td>
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
