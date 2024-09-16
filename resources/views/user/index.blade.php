@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center h-100 mt-5">
        <div class="text-center">
            <img src="{{ asset('herkobi.png') }}" alt="Herkobi Panel" class="img-fluid mw-300 mb-3">
            <h1>Herkobi Panel</h1>
            <p>Herkobi Dijital Çözümler<br>Yazılım San. ve Tic. A.Ş.</p>
            <p>&copy; <?php echo date('Y'); ?></p>
        </div>
    </div>
@endsection
