<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ config('panel.title') }}</title>
    <link rel="shortcut icon" href="{{ asset(config('panel.favicon')) }}" type="image/png">
    @vite(['resources/scss/front.scss', 'resources/js/front.js'])
    @yield('css')
</head>

<body>
    @yield('content')
    @yield('js')
</body>

</html>
