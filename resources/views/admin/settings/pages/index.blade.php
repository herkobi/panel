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
                <div class="card border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Sayfalar &amp; Sözleşmeler</h1>
                            <a href="{{ route('panel.settings.page.create') }}"
                                class="btn btn-primary btn-sm rounded-sm">Yeni Sayfa</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="w-10">Durum</th>
                                    <th class="w-80">Sayfa Adı</th>
                                    <th class="w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
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
                                            <a href="{{ route('panel.settings.page.edit', $page->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Sayfa Bilgileri">
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
