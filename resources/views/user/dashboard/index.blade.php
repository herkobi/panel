@extends('layouts.app')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                @include('user.layout.page-header', [
                    'subtitle' => config('panel.title'),
                    'title' => 'Başlangıç',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
    </div>
@endsection
