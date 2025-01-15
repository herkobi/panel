@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    @include('admin.tools.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3">
                    @include('admin.tools.config.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-6">
                            <h2>Sistem Dilleri</h2>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav justify-content-end">
                                <li class="nav-item">
                                    <a href="{{ route('panel.tools.config.language.create') }}" class="btn"
                                        title="Yeni Dil">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2">
                                            </path>
                                        </svg>
                                        Dil Ekle
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
                                    <th class="w-20">Dil Adı</th>
                                    <th class="w-30">Kod-Bölgesel Kod</th>
                                    <th class="w-30">Karakter Seti - Metin Yönü</th>
                                    <th class="w-10"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($languages as $language)
                                    <tr>
                                        <td>
                                            @if ($language->status->value == 1)
                                                <span class="badge bg-success">{{ Status::title($language->status) }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ Status::title($language->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $language->name }}</td>
                                        <td>{{ $language->code }} - {{ $language->regional_code }}</td>
                                        <td>{{ $language->charset }} - {{ $language->direction }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('panel.tools.config.language.edit', $language->id) }}"
                                                class="btn btn-sm" title="Dil Bilgileri">
                                                Düzenle
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($languages->hasPages())
                            {{ $languages->links('vendor.pagination.bootstrap-5') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
