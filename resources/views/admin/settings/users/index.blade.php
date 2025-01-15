@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    @include('admin.settings.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row align-items-center mb-2">
                <div class="col-lg-6">
                    <h2 class="mb-0">Kayıtlı Yöneticiler</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                            <a href="{{ route('panel.settings.user.create') }}" class="btn" title="Yeni Yönetici">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-plus-lg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                                Yönetici Ekle
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="w-10">Durum</th>
                            <th class="w-30">Ad Soyad</th>
                            <th class="w-30">E-posta Adresi</th>
                            <th class="w-20">Görev</th>
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
                                <td>{{ $user->title }}</td>
                                <td class="text-center">
                                    <a href="{{ $user->id === auth()->user()->id ? route('panel.profile') : route('panel.settings.user.detail', $user->id) }}"
                                        class="btn btn-sm" title="Kullanıcı Bilgileri">
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
@endsection
