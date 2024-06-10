<div class="dropdown-menu panel-dropdown shadow-none pb-0">
    <span class="dropdown-header">Tanımlamalar</span>
    @if (auth()->user()->can('gateway.management'))
        @if (!request()->routeIs(['panel.settings.payments', 'panel.settings.payment.edit', 'panel.gateways.*']))
            <a class="dropdown-item {{ request()->routeIs(['panel.settings.payments', 'panel.settings.payment.edit', 'panel.gateways.*']) ? 'active' : '' }}"
                href="{{ route('panel.settings.payments') }}"
                title="{{ __('admin/settings/payments.navigation.payments') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                    <path d="M3 10h18" />
                    <path d="M16 19h6" />
                    <path d="M19 16l3 3l-3 3" />
                    <path d="M7.005 15h.005" />
                    <path d="M11 15h2" />
                </svg>
                {{ __('admin/settings/payments.navigation.payments') }}
            </a>
        @endif
    @endif
    @if (request()->routeIs(['panel.settings.taxes', 'panel.settings.tax.*']))
        <div class="dropdown-divider my-0"></div>
    @endif
    @if (auth()->user()->can('tax.management'))
        <a class="dropdown-item {{ request()->routeIs(['panel.settings.taxes', 'panel.settings.tax.edit']) ? 'active' : '' }}"
            href="{{ route('panel.settings.taxes') }}" title="Vergi Bilgileri">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 21l18 0" />
                <path d="M3 10l18 0" />
                <path d="M5 6l7 -3l7 3" />
                <path d="M4 10l0 11" />
                <path d="M20 10l0 11" />
                <path d="M8 14l0 3" />
                <path d="M12 14l0 3" />
                <path d="M16 14l0 3" />
            </svg>
            Vergi Oranları
        </a>
    @endif
    @if (auth()->user()->can('tax.create'))
        @if (request()->routeIs(['panel.settings.taxes', 'panel.settings.tax.*']))
            <a class="dropdown-item {{ request()->routeIs('panel.settings.tax.create') ? 'active' : '' }}"
                href="{{ route('panel.settings.tax.create') }}" title="Yeni Vergi Oranı">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Vergi Oranı Ekle
            </a>
            <div class="dropdown-divider my-0"></div>
        @endif
    @endif
    @if (request()->routeIs(['panel.settings.currencies', 'panel.settings.currency.*']))
        <div class="dropdown-divider my-0"></div>
    @endif
    @if (auth()->user()->can('currency.management'))
        <a class="dropdown-item {{ request()->routeIs(['panel.settings.currencies', 'panel.settings.currency.edit']) ? 'active' : '' }}"
            href="{{ route('panel.settings.currencies') }}" title="Para Birimleri">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
            </svg>
            Para Birimleri
        </a>
    @endif
    @if (auth()->user()->can('currency.create'))
        @if (request()->routeIs(['panel.settings.currencies', 'panel.settings.currency.*']))
            <a class="dropdown-item {{ request()->routeIs('panel.settings.currency.create') ? 'active' : '' }}"
                href="{{ route('panel.settings.currency.create') }}" title="Yeni Para Birimi">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Para Birimi Ekle
            </a>
            <div class="dropdown-divider my-0"></div>
        @endif
    @endif
    @if (request()->routeIs('panel.settings.locations.*'))
        <div class="dropdown-divider my-0"></div>
    @endif
    @if (auth()->user()->can('location.management'))
        <a class="dropdown-item {{ request()->routeIs(['panel.settings.locations.countries', 'panel.settings.locations.states', 'panel.settings.locations.country.edit', 'panel.settings.locations.state.*']) ? 'active' : '' }}"
            href="{{ route('panel.settings.locations.countries') }}" title="Konum Bilgileri">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                <path d="M9 4v13" />
                <path d="M15 7v5.5" />
                <path
                    d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                <path d="M19 18v.01" />
            </svg>
            Konum Bilgileri
        </a>
    @endif
    @if (auth()->user()->can('location.create'))
        @if (request()->routeIs('panel.settings.locations.*'))
            <a class="dropdown-item {{ request()->routeIs('panel.settings.locations.country.create') ? 'active' : '' }}"
                href="{{ route('panel.settings.locations.country.create') }}" title="Yeni Ülke">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Yeni Ülke Ekle
            </a>
            <div class="dropdown-divider my-0"></div>
        @endif
    @endif
    @if (request()->routeIs(['panel.settings.languages', 'panel.settings.language.*']))
        <div class="dropdown-divider my-0"></div>
    @endif
    @if (auth()->user()->can('language.management'))
        <a class="dropdown-item {{ request()->routeIs(['panel.settings.languages', 'panel.settings.language.edit']) ? 'active' : '' }}"
            href="{{ route('panel.settings.languages') }}" title="Diller">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="icon dropdown-item-icon">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 5h7" />
                <path d="M9 3v2c0 4.418 -2.239 8 -5 8" />
                <path d="M5 9c0 2.144 2.952 3.908 6.7 4" />
                <path d="M12 20l4 -9l4 9" />
                <path d="M19.1 18h-6.2" />
            </svg>
            Diller
        </a>
    @endif
    @if (auth()->user()->can('language.create') &&
            request()->routeIs(['panel.settings.languages', 'panel.settings.language.*']))
        <a class="dropdown-item {{ request()->routeIs('panel.settings.language.create') ? 'active' : '' }}"
            href="{{ route('panel.settings.language.create') }}" title="Yeni Dil">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Yeni Dil Ekle
        </a>
    @endif
</div>
