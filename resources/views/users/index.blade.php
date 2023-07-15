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
                            <table id="user-table" class="table table-striped">
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
                                                        <li class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item small" href="#"
                                                                data-bs-toggle="modal" data-bs-target="#changeRole">Rol
                                                                Tanımla</a>
                                                        </li>
                                                        <li><a class="dropdown-item small"
                                                                href="{{ route('panel.user.permissions', $user->id) }}">Özel
                                                                Yetkiler</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{ $users->links() }}
                                </tfoot>
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
                        <div class="input-group custom-input-group">
                            <input type="text" class="form-control rounded-0 shadow-none" placeholder="Hesap Adı"
                                aria-label="Hesap Ara" aria-describedby="button-search" id="searchText">
                            <button class="btn btn-outline-secondary rounded-0 shadow-none border-left-0" type="button"
                                id="button-search"><i class="ri-search-2-line"></i></button>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Durum</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach (UserStatus::cases() as $userStatus)
                                    <li class="list-group-item bg-white">
                                        <div class="form-check">
                                            <input class="form-check-input rounded-0 shadow-none status" type="checkbox"
                                                name="status[]" value="{{ $userStatus->value }}"
                                                id="user-status-select-{{ $userStatus->value }}"
                                                onclick="checkStatus(this)">
                                            <label class="form-check-label"
                                                for="user-status-select-{{ $userStatus->value }}">{{ UserStatus::getTitle($userStatus->value) }}
                                                Hesaplar</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if ($tags->count() > 0)
                        <div class="card rounded-0 shadow-sm border-0 mb-3">
                            <div class="card-header border-0 bg-white pt-3 pb-0">
                                <h4 class="card-title mb-0">Etiketler</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($tags as $tag)
                                        <li class="list-group-item bg-white">
                                            <div class="form-check">
                                                <input class="form-check-input rounded-0 shadow-none tag" type="checkbox"
                                                    name="tag[]" value="{{ $tag->id }}"
                                                    id="user-tag-select-{{ $tag->id }}" onclick="checkTag(this)">
                                                <label class="form-check-label"
                                                    for="user-tag-select-{{ $tag->id }}">{{ $tag->name }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="changeRoleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 shadow-none bg-white">
                <form action="{{ route('panel.user.update.role', $user->id) }}" method="POST" id="change-role">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changeRoleLabel">Kullanıcı Rol Ekle/Değiştir</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-5 fw-semibold mb-0" for="user-default-role">Tanımlı
                                    Rol</label>
                                <div class="col-md-7">
                                    <ul class="list-unstyled list-inline m-0 p-0">
                                        @foreach ($user->getRoleNames() as $role)
                                            <li><span class="fw-semibold mr-2 mb-2">{{ $role }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-5 fw-semibold mb-0" for="add-user-role">Rol
                                    Tanımla/Değiştir</label>
                                <div class="col-md-7">
                                    @foreach ($roles as $key => $role)
                                        <div class="form-check form-check-inline">
                                            @foreach ($user->roles as $userrole)
                                                <input class="form-check-input rounded-0 shadow-none" type="checkbox"
                                                    id="role-permission-{{ $key }}" name="role[]"
                                                    value="{{ $role->id }}"
                                                    {{ $role->id == $userrole->id ? 'checked' : '' }}>
                                            @endforeach
                                            <label class="form-check-label"
                                                for="role-permission-{{ $key }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <button type="button" class="btn btn-secondary btn-sm rounded-0 shadow-none"
                                data-bs-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn btn-primary btn-sm rounded-0 shadow-none">Rol
                                Tanımla</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@php
    $userStatusCases = [];
    foreach (UserStatus::cases() as $key => $case) {
        $userStatusCases[$key]['value'] = $case->value;
        $userStatusCases[$key]['title'] = UserStatus::getTitle($case->value);
        $userStatusCases[$key]['color'] = UserStatus::color($case);
    }
@endphp

@section('js')
    <script>
        const userStatusCases = @json($userStatusCases);
        let statusIds = [];
        let tagIds = [];

        function checkStatus(element) {
            const value = element.value;

            const isChecked = element.checked;

            if (isChecked) {
                statusIds.push(value)
            } else {
                if (statusIds.length > 0) {
                    statusIds = statusIds.filter(item => item !== value)
                }
            }



            filter();
        }

        function checkTag(element) {
            const value = element.value;

            const isChecked = element.checked;

            if (isChecked) {
                tagIds.push(value)
            } else {
                if (tagIds.length > 0) {
                    tagIds = tagIds.filter(item => item !== value)
                }
            }



            filter();
        }

        function filter() {
            console.log("tagIds", tagIds)
            console.log("statusIds", statusIds)
            $.ajax({
                type: 'GET',
                // url: '{{ route('panel.user.filter') }}' + '?tagIds=' + tagIds + '&statusIds=' + statusIds,
                url: '{{ route('panel.user.filter') }}',
                data: {
                    tagIds: tagIds,
                    statusIds: statusIds,
                    page: {{ $users->currentPage() }}
                },
                success: function(response) {
                    deleteRows();
                    refreshRows(response);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function deleteRows() {
            var tableHeaderRowCount = 1;
            var table = document.getElementById('user-table');
            var rowCount = table.rows.length;
            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                table.deleteRow(tableHeaderRowCount);
            }
        }

        function refreshRows(data) {

            console.log("data", data)

            if (!Array.isArray(data) && data.length === 0) {
                return;
            }

            if (Object.keys(data).length === 0) {
                return;
            }

            data.forEach(item => {
                const table = document.getElementById('user-table');
                const row = table.insertRow();
                const statusCell = row.insertCell(0);
                const nameCell = row.insertCell(1);
                const emailCell = row.insertCell(2);
                const roleCell = row.insertCell(3);
                const actionCell = row.insertCell(4);

                const status = userStatusCases.find(i => i.value === parseInt(item.status));

                statusCell.innerHTML = `<span class="badge fw-normal ${status.color}">${status.title}</span>`;
                nameCell.innerHTML = item.name;
                emailCell.innerHTML = item.email;
                roleCell.innerHTML = item.roleName;
                actionCell.innerHTML = `<div class="dropdown">
                                            <a class="btn btn-text dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="ri-menu-3-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end rounded-0 shadow-none bg-white">
                                                <li><a class="dropdown-item small" href="/panel/user/detail/${item.id}">Bilgiler</a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item small" href="#">Rol Tanımla</a>
                                                </li>
                                                <li><a class="dropdown-item small" href="/panel/user/permissions/${item.id}">Özel Yetkiler</a>
                                                </li>
                                            </ul>
                                        </div>`;

            })
        }

        document.getElementById('button-search').addEventListener('click', function() {
            const searchText = document.getElementById('searchText').value;

            if (searchText.length === 0) {
                return;
            }

            $.ajax({
                type: 'GET',
                url: '{{ route('panel.user.filter') }}',
                data: {
                    searchText: searchText,
                    page: {{ $users->currentPage() }},
                    tagIds: tagIds,
                    statusIds: statusIds,
                },
                success: function(response) {
                    deleteRows();
                    refreshRows(response);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        })
    </script>
@endsection
