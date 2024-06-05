<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        @if (auth()->user()->can('tax.management'))
            @if (isset($first_link))
                <span class="d-none d-sm-inline">
                    <a href="{{ route($first_link) }}" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-building-bank">
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
                        {{ $first_button }}
                    </a>
                </span>
            @endif
        @endif
        @if (auth()->user()->can('tax.create'))
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
