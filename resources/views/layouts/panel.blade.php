<!DOCTYPE html>
<html lang="tr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ Setting::get('title') }}</title>
    <link rel="shortcut icon" href="{{ Setting::get('favicon') }}" type="image/png">
    @vite(['resources/sass/panel.scss', 'resources/js/panel.js'])
    @yield('css')
</head>

<body class="d-flex flex-column h-100">
    <div class="sidebar-area">
        @include('admin.include.sidebar')
    </div>
    <div class="page flex-grow-1 d-flex flex-column">
        <div class="container-fluid d-flex flex-column flex-grow-1">
            @yield('content')
        </div>
    </div>
    @yield('js')

    @if (Session::has('success'))
        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Başarılı</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kapat</button>
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
                        <h5 class="modal-title">Hata</h5>
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
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Kapat</button>
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
</body>

</html>
