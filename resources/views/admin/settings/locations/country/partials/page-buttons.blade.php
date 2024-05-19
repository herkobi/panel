<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        @if (isset($first_link))
            <span class="d-none d-sm-inline">
                <a href="{{ route($first_link) }}" class="btn btn-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                        <path d="M9 4v13" />
                        <path d="M15 7v5.5" />
                        <path
                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                        <path d="M19 18v.01" />
                    </svg>
                    {{ $first_button }}
                </a>
            </span>
        @endif
        @if (isset($second_link))
            <a href="{{ route($second_link) }}" class="btn btn-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v8.5" />
                    <path d="M9 4v13" />
                    <path d="M15 7v8" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                </svg>
                {{ $second_button }}
            </a>
            <a href="{{ route($second_link) }}" class="btn btn-primary d-sm-none btn-icon"
                aria-label="{{ $second_button }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v8.5" />
                    <path d="M9 4v13" />
                    <path d="M15 7v8" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                </svg>
            </a>
        @endif
    </div>
</div>
