@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Yöeticiler'])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-9">
                <div class="card rounded-0 shadow-sm border-0">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <h4 class="card-title mb-0">Kayıtlı Yöeticiler</h4>
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
                                                                href="{{ route('panel.admin.detail', $user->id) }}">Bilgiler</a>
                                                        </li>
                                                        <li><a class="dropdown-item admin"
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var statusIds = [];

        function checkStatus(element) {
            const value = element.value;
            const isChecked = element.checked;
            if (isChecked) {
                statusIds.push(value)
            } else {
                statusIds = statusIds.filter(item => item !== value)
            }
            filter();
        }

        function filter() {
            $.ajax({
                type: 'GET',
                url: '{{ route('panel.admin.filter') }}',
                data: {
                    statusIds
                },
                success: function(response) {
                    deleteRows();
                    refreshRows(response);
                },
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
            const table = document.getElementById('user-table');
            for (const [key, value] of Object.entries(data.users)) {
                const tr = table.insertRow();
                const cell1 = tr.insertCell(0);
                cell1.innerHTML = "1";
                const cell2 = tr.insertCell(1);
                cell2.innerHTML = "1";
                const cell3 = tr.insertCell(2);
                cell3.innerHTML = "1";
                const cell4 = tr.insertCell(3);
                cell4.innerHTML = "1";
                const cell5 = tr.insertCell(4);
                cell5.innerHTML = "1";
            }
        }
    </script>
@endsection