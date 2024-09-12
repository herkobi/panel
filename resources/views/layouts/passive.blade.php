<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ Setting::get('title') }}</title>
    <link rel="shortcut icon" href="{{ Setting::get('favicon') }}" type="image/png">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @yield('css')
</head>

<body class="d-flex flex-column auth">
    <div class="row g-0 flex-fill">
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}" height="56">
                    </div>
                    <h2 class="h2 mb-3">Hesabınız Dondurulmuştur</h2>
                    <p class="text-muted mb-3">Hesabınız dondurulmuştur, lütfen iletişime geçiniz.</p>
                    <div class="d-flex align-items-center justify-content-between my-3 w-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                onclick="event.preventDefault(); this.closest('form').submit();">Oturumu Kapat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
