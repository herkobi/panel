@extends('layouts.app')
@section('content')
    <div class="page-content position-relative mb-4">
        {{ Auth::user()->name }}
        Hesabınız dondurulmuştur. Lütfen iletişime geçiniz.
    </div>
@endsection
