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
                            <h1 class="card-title">İşlem Kayıtları</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($activityLogs as $activity)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="row">
                                    <div class="col-lg-3">{{ $activity->created_at }}</div>
                                    <div class="col-lg-9">
                                        <h4>{{ $activity->message }}</h4>
                                        <span class="text-secondary">
                                            {{ $activity->log }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
