<div class="page-toolbar position-relative py-3">
    <div class="d-flex align-items-center justify-content-between">
        <span id="hamburger" class="menu-toggle text-decoration-none fs-5 text-white d-block d-md-none">
            <i class="ri-menu-4-line"></i>
        </span>
        <ul class="toolbar-menu list-unstyled list-inline mb-0 ms-auto">
            <li class="list-inline-item">
                <a href="{{ route('panel.profile') }}" title="Profil" class="text-decoration-none text-white">
                    <div class="d-flex align-item-center justify-content-between">
                        <i class="ri-user-follow-line"></i>
                        <span class="align-middle ms-1">Bilgilerim</span>
                    </div>
                </a>
            </li>
            <li class="list-inline-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none text-white p-0 rounded-0 shadow-none" onclick="event.preventDefault(); this.closest('form').submit();">
                        <div class="d-flex align-items-center justify-content-between">
                            <i class="ri-logout-circle-r-line"></i>
                            <span class="align-middle ms-1">Oturumu Kapat</span>
                        </div>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
