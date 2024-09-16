@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                    @include('admin.settings.include.navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Yönetici Hesapları</h1>
                            <a href="{{ route('panel.settings.user.create') }}"
                                class="btn btn-primary btn-sm rounded-sm">Yeni Kişi Ekle</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-start text-nowrap">
                            <thead>
                                <tr>
                                    <th class="w-10">Tür</th>
                                    <th class="w-40">Ad Soyad</th>
                                    <th class="w-40">E-posta Adresi</th>
                                    <th class="w-10"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            @if ($user->status->value == 1)
                                                <span
                                                    class="badge bg-success">{{ AccountStatus::fromValue($user->status->value)?->title() ?? 'Unknown Status' }}</span>
                                            @else
                                                <span
                                                    class="badge bg-primary">{{ AccountStatus::fromValue($user->status->value)?->title() ?? 'Unknown Status' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->name . ' ' . $user->surname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <a href="{{ $user->id === auth()->user()->id ? route('panel.profile') : route('panel.settings.user.detail', $user->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Kullanıcı Bilgileri">
                                                Bilgiler
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
