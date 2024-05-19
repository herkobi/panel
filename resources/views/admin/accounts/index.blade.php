@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Hesaplar',
                ])
                @include('admin.accounts.partials.page-buttons', [
                    'first_button' => 'Hesaplar',
                    'first_link' => 'panel.accounts',
                    'second_button' => 'Yeni Hesap Ekle',
                    'second_link' => 'panel.account.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title lh-1">Kullanıcı Hesapları</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-40">Ad Soyad</th>
                                        <th class="w-20">E-posta Adresi</th>
                                        <th class="w-20">Yetkiler</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                @if ($user->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ AccountStatus::title($user->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ AccountStatus::title($user->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $user->name . ' ' . $user->surname }}</td>
                                            <td class="fw-bold">{{ $user->email }}</td>
                                            <td>
                                                <ul class="list-unstyled list-inline m-0 p-0">
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <li><span class="fw-semibold mr-2 mb-2">{{ $role }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.account.detail', $user->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Bilgiler">
                                                    Bilgiler
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @include('admin.accounts.partials.navigation')
                </div>
            </div>
        </div>
    </div>
@endsection
