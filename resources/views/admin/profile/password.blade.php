@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Profil Bilgileri',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2 p-2">
                    @include('admin.profile.include.navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
            </div>
        </div>
    </div>
@endsection
