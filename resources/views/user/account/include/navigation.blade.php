<div class="page-menu border-bottom mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav justify-content-start">
                    <li class="nav-item {{ request()->routeIs(['app.profile', 'app.profile.*']) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('app.profile') }}" title="Bilgilerim">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-person" viewBox="0 0 20 20">
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z">
                                </path>
                            </svg>
                            Profil Bilgilerim
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
