<div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
        <div class="page-title-area">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2 me-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 6l16 0" />
                            <path d="M4 12l16 0" />
                            <path d="M4 18l16 0" />
                        </svg>
                        <div class="page-title">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-area d-none d-md-block">
            <nav class="nav">
                <a href="{{ route('panel.profile') }}"
                    class="nav-link p-0 me-3 {{ request()->routeIs('panel.profile') ? 'active' : '' }}"
                    aria-current="page">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    </svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" title="Oturumu Kapat" class="nav-link p-0"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M9 12h12l-3 -3" />
                            <path d="M18 15l3 -3" />
                        </svg>
                    </a>
                </form>
            </nav>
        </div>
    </div>
</div>
