<!DOCTYPE html>
<html lang="tr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ Setting::get('title') }}</title>
    <link rel="shortcut icon" href="{{ Setting::get('favicon') }}" type="image/png">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css')
</head>

<body>
    @include('user.include.sidebar')
    <div class="page-wrapper">
        <div class="page-content">
            @yield('content')
        </div>
    </div>
    @yield('js')

    @if (Session::has('success'))
        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Başarılı!</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (Session::has('success'))
                    var successModal = new bootstrap.Modal(document.getElementById('modal-success'));
                    successModal.show();
                @endif
            });
        </script>
    @endif
    @if (Session::has('error') || $errors->any())
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hata!</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="text-secondary">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-secondary">{{ Session::get('error') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (Session::has('error') || $errors->any())
                    var errorModal = new bootstrap.Modal(document.getElementById('modal-danger'));
                    errorModal.show();
                @endif
            });
        </script>
    @endif
    @if (Session::has('warning'))
        <div class="modal modal-blur fade" id="modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Uyarı!</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-secondary">{{ Session::get('warning') }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var warningModal = new bootstrap.Modal(document.getElementById('modal-warning'));
                warningModal.show();
            });
        </script>
    @endif
</body>

</html>


{{-- <!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ Setting::get('title') }}</title>
    <link rel="shortcut icon" href="{{ Setting::get('favicon') }}" type="image/png">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css')
</head>

<body>
    <header class="app-header border-bottom">
        <nav class="navbar navbar-expand-md navbar-light navbar-top bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ route('app.home') }}">
                    <img src="{{ asset('herkobi.png') }}" alt="Herkobi Panel" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#herkobiNav"
                    aria-controls="herkobiNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="herkobiNav">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('app.home') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('app.home') }}" title="{{ Setting::get('title') }}">Ana Sayfa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('app.account.*') ? 'active' : '' }}"
                                title="Hesabım" href="{{ route('app.account.plans') }}">Hesabım</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('app.profile') ? 'active' : '' }}"
                                title="Bilgilerim" href="{{ route('app.profile') }}">Bilgilerim</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" title="Oturumu Kapat" class="nav-link"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-logout m-n4">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                        <path d="M9 12h12l-3 -3" />
                                        <path d="M18 15l3 -3" />
                                    </svg>
                                    Oturumu Kapat
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="app-footer position-relative float-left w-100 bottom-0 bg-white border-top mt-5">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
                <div class="col-md-4">
                    <a href="{{ route('app.home') }}" class="mb-3 mb-md-0">
                        <img src="/{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}">
                    </a>
                </div>
                <span class="text-body-secondary">&copy; <?php echo date('Y'); ?>
                    {{ Setting::get('title') }}</span>
                <ul class="nav justify-content-end list-unstyled d-flex col-md-4">
                    <li class="nav-item">
                        <a href="https://panel.herkobi.com" class="nav-link px-2 text-body-secondary"
                            target="_blank">Herkobi</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://github.com/herkobi" class="nav-link px-2 text-body-secondary"
                            target="_blank">Github</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    @yield('js')

    @if (Session::has('success'))
        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Başarılı!</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (Session::has('success'))
                    var successModal = new bootstrap.Modal(document.getElementById('modal-success'));
                    successModal.show();
                @endif
            });
        </script>
    @endif
    @if (Session::has('error') || $errors->any())
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hata!</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="text-secondary">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-secondary">{{ Session::get('error') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (Session::has('error') || $errors->any())
                    var errorModal = new bootstrap.Modal(document.getElementById('modal-danger'));
                    errorModal.show();
                @endif
            });
        </script>
    @endif
    @if (Session::has('warning'))
        <div class="modal modal-blur fade" id="modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Uyarı!</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-secondary">{{ Session::get('warning') }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var warningModal = new bootstrap.Modal(document.getElementById('modal-warning'));
                warningModal.show();
            });
        </script>
    @endif
</body>

</html> --}}
