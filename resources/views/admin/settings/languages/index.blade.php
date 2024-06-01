@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Para Birimleri',
                ])
                @include('admin.settings.languages.partials.page-buttons', [
                    'first_button' => 'Diller',
                    'first_link' => 'panel.settings.languages',
                    'second_button' => 'Yeni Dil Ekle',
                    'second_link' => 'panel.settings.language.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.partials.definitions')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Diller</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-20">Bayrak</th>
                                        <th class="w-20">Dil Adı</th>
                                        <th class="w-20">Kısa Kod</th>
                                        <th class="w-20">Bölgesel Kod</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languages as $language)
                                        <tr>
                                            <td>
                                                @if ($language->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($language->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($language->status) }}</span>
                                                @endif
                                            </td>
                                            <td><span class="flag flag-xs flag-country-{{ $language->code }}"></span></td>
                                            <td class="fw-bold">{{ $language->title }}</td>
                                            <td>{{ $language->code }}</td>
                                            <td>{{ $language->iso_code }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.settings.language.edit', $language->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Düzenle">
                                                    Düzenle
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $languages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
