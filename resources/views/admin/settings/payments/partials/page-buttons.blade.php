<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        @if (auth()->user()->can('gateway.management'))
            @if (isset($first_link))
                <span class="d-none d-sm-inline">
                    <a href="{{ route($first_link) }}" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-credit-card-pay">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                            <path d="M3 10h18" />
                            <path d="M16 19h6" />
                            <path d="M19 16l3 3l-3 3" />
                            <path d="M7.005 15h.005" />
                            <path d="M11 15h2" />
                        </svg>
                        {{ $first_button }}
                    </a>
                </span>
            @endif
        @endif
        @if (auth()->user()->can('gateway.bac.create'))
            @if (isset($second_link))
                <a href="{{ route($second_link) }}" class="btn btn-primary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    {{ $second_button }}
                </a>
                <a href="{{ route($second_link) }}" class="btn btn-primary d-sm-none btn-icon"
                    aria-label="{{ $second_button }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                </a>
            @endif
        @endif
    </div>
</div>
