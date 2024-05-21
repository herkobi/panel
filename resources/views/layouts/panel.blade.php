<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Herkobi Panel</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @yield('css')
</head>
<body class="app">
    <div class="page">
        @include('admin.layout.header')
        <div class="page-wrapper">
            @yield('content')
            @include('admin.layout.footer')
        </div>
    </div>
    @yield('js')
</body>
</html>