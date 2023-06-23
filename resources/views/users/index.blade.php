@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Kullanıcılar'])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-9">
                <div class="card rounded-0 shadow-sm border-0">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Kayıtlı Kullanıcılar</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-responsive-lg">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Durum</th>
                                        <th scope="col">Kullanıcı Adı</th>
                                        <th scope="col">E-posta Adresi</th>
                                        <th scope="col">Yetkiler</th>
                                        <th scope="col" class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td><span
                                                    class="badge fw-normal {{ UserStatus::color($user->status) }}">{{ UserStatus::title($user->status) }}</span>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <ul class="list-unstyled list-inline m-0 p-0">
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <li><span class="fw-semibold mr-2 mb-2">{{ $role }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-text dropdown-toggle p-0" href="#"
                                                        role="button" data-bs-toggle="dropdown" data-boundary="window"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="ri-menu-3-fill"></i>
                                                    </a>
                                                    <ul
                                                        class="dropdown-menu dropdown-menu-end rounded-0 shadow-none bg-white">
                                                        <li><a class="dropdown-item small"
                                                                href="{{ route('panel.user.detail', $user->id) }}">Bilgiler</a>
                                                        </li>
                                                        <li><a class="dropdown-item small"
                                                                href="{{ route('panel.user.edit', $user->id) }}">Düzenle</a>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item small" href="#">Rol Tanımla</a>
                                                        </li>
                                                        <li><a class="dropdown-item small"
                                                                href="{{ route('panel.admin.permissions', $user->id) }}">Özel
                                                                Yetkiler</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Hesap Ara</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="input-group custom-input-group">
                                <input type="text" class="form-control rounded-0 shadow-none" placeholder="Hesap Adı"
                                    aria-label="Hesap Ara" aria-describedby="button-search">
                                <button class="btn btn-outline-secondary rounded-0 shadow-none border-left-0" type="button"
                                    id="button-search"><i class="ri-search-2-line"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Durum</h4>
                        </div>
                        <div class="card-body">
                            @foreach (UserStatus::cases() as $searhStatus)
                                <div class="form-check">
                                    <input class="form-check-input rounded-0 shadow-none" type="checkbox" name="status[]"
                                        value="{{ $searhStatus->value }}" id="user-status-select">
                                    <label class="form-check-label"
                                        for="user-status-select">{{ UserStatus::getTitle($searhStatus->value) }}
                                        Hesaplar</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Kategoriler</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-white">
                                    <div class="form-check">
                                        <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                            name="category[]" value="kategori-adi" id="categoryField">
                                        <label class="form-check-label" for="categoryField">Kategori Adı</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" name="s" id="searchField"
                                    class="btn btn-primary rounded-0 shadow-none">Ara</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
