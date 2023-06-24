<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Herkobi Panel</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @yield('css')
</head>

<body class="app">
    <div class="wrapper">
        @include('layouts.partials.sidebar')
        <div class="main">
            <div class="container-fluid g-5">
                @include('layouts.partials.header')
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.partials.footer')
    @yield('js')
</body>

</html>
