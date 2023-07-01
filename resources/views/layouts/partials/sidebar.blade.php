<aside id="sidebar" class="sidebar">
    <div class="logo-area d-flex align-items-start justify-content-between">
        <a class="logo" href="{{ Auth::user()->type == UserType::ADMIN ? route('panel.admin') : route('panel.home') }}">
            <img src="{{ asset('herkobi.png') }}" alt="Herkobi">
        </a>
        <span class="d-block d-md-none close"><i class="ri-close-circle-line"></i></span>
    </div>
    <div class="sidebar-content" data-simplebar>
        @if (auth()->user()->type == UserType::USER)
            @include('layouts.partials.navigation-user')
        @else
            @include('layouts.partials.navigation-admin')
        @endif
    </div>
</aside>
