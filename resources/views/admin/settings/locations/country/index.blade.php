@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Ülkeler',
                ])
                @include('admin.settings.locations.country.partials.page-buttons', [
                    'first_button' => 'Ülkeler',
                    'first_link' => 'panel.settings.locations.countries',
                    'second_button' => 'Yeni Ülke Ekle',
                    'second_link' => 'panel.settings.locations.country.create',
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
                            <h1 class="card-title">Ülkeler</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-40">Ülke</th>
                                        <th class="w-20">Kod</th>
                                        <th class="w-20">Bölgeler</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>
                                                @if ($country->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($country->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($country->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $country->title }}</td>
                                            <td>{{ $country->code }}</td>
                                            <td><a href="{{ route('panel.settings.locations.states', $country->id) }}"
                                                    class="btn btn-ghost-secondary btn-sm" title="Bölgeler">Bölgeler</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.settings.locations.country.edit', $country->id) }}"
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
                            {{ $countries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
