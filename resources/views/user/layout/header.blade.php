<header class="navbar navbar-expand-md d-print-none">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('app.home') }}">
                <img src="{{ asset('herkobi.png') }}" alt="{{ config('panel.title') }}" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar">US</span>
                    <div class="d-none d-lg-block ps-2">
                        <div>{{ auth()->user()?->name . ' ' . auth()->user()?->surname }}</div>
                        <div class="mt-1 small text-muted">{{ auth()->user()?->type->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('app.profile') }}" class="dropdown-item" title="Profil Bilgileri">Profil
                        Bilgileri</a>
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                        <a href="{{ route('app.profile.twofactor') }}" class="dropdown-item"
                            title="İki Faktörlü Doğrulama">İki Faktörlü Doğrulama</a>
                    @endif
                    <div class="dropdown-divider my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item" title="Oturumu Kapat"
                            onclick="event.preventDefault(); this.closest('form').submit();">Oturumu Kapat</a>
                    </form>
                </div>
            </div>
        </div>
        @include('user.layout.navigation')
    </div>
</header>
