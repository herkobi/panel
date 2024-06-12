<div class="dropdown-menu panel-dropdown shadow-none pb-0">
    <span class="dropdown-header"> {{ __('admin/settings/payments.navigation.title') }}
    </span>
    @if (auth()->user()->can('gateway.management'))
        <a class="dropdown-item {{ request()->routeIs('panel.settings.payments') ? 'active' : '' }}"
            href="{{ route('panel.settings.payments') }}" title="{{ __('admin/settings/payments.navigation.title') }}">
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
        <div class="dropdown-divider my-0"></div>
        @foreach ($payments as $payment)
            <a class="dropdown-item {{ request()->routeIs(['panel.gateways.' . $payment->code]) ? 'active' : '' }}"
                href="{{ route('panel.gateways.' . $payment->code) }}" title="{{ $payment->title }}">
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
                {{ $payment->title }}
            </a>
        @endforeach
    @endif
</div>
