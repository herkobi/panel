<a href="{{ route('panel.profile') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile') ? 'active' : '' }} py-3">{{ __('admin/profile/navigation.panel.profile') }}</a>
@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
    <a href="{{ route('panel.profile.twofactor') }}"
        class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.twofactor') ? 'active' : '' }} py-3">{{ __('admin/profile/navigation.panel.profile.twofactor') }}</a>
@endif
<a href="{{ route('panel.profile.activity') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.activity') ? 'active' : '' }} py-3">{{ __('admin/profile/navigation.panel.profile.activity') }}</a>
<a href="{{ route('panel.profile.authlogs') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.authlogs') ? 'active' : '' }} py-3">{{ __('admin/profile/navigation.panel.profile.authlogs') }}</a>
