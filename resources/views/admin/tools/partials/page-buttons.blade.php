<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        @if (isset($first_link))
            <span class="d-none d-sm-inline">
                <a href="{{ route($first_link) }}" class="btn btn-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-notebook">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                        <path d="M13 8l2 0" />
                        <path d="M13 12l2 0" />
                    </svg>
                    {{ $first_button }}
                </a>
            </span>
        @endif
        @if (isset($second_link))
            <a href="{{ route($second_link) }}" class="btn btn-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-reload">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                    <path d="M20 4v5h-5" />
                </svg>
                {{ $second_button }}
            </a>
            <a href="{{ route($second_link) }}" class="btn btn-primary d-sm-none btn-icon"
                aria-label="{{ $second_button }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-reload">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                    <path d="M20 4v5h-5" />
                </svg>
            </a>
        @endif
    </div>
</div>
