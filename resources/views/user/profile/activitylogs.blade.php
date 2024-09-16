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
                            <h2 class="border-bottom mb-4 pb-3">İşlem Kayıtları</h2>
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
    </div>
@endsection
