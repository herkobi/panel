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
                    <h2 class="mb-0">Kayıtlı Sayfalar</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                            <a href="{{ route('panel.settings.page.create') }}" class="btn" title="Yeni Sayfa">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-plus-lg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                                Sayfa Ekle
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
                            <th class="w-80">Sayfa Adı</th>
                            <th class="w-10"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>
                                    @if ($page->status->value == 1)
                                        <span class="badge bg-success">{{ Status::title($page->status) }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ Status::title($page->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $page->title }}</td>
                                <td class="text-center">
                                    <a href="{{ route('panel.settings.page.edit', $page->id) }}" class="btn btn-sm"
                                        title="Sayfa Bilgileri">
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
