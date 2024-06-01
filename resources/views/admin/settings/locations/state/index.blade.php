@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Bölgeler',
                ])
                @include('admin.settings.locations.state.partials.page-buttons', [
                    'first_button' => 'Ülkeler',
                    'first_link' => 'panel.settings.locations.countries',
                    'second_button' => 'Yeni Bölge Ekle',
                    'second_link' => 'panel.settings.locations.state.create',
                    'country' => $country->id,
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
                            <h1 class="card-title">{{ $country->title . ' Bölgeleri' }}</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-60">Bölge Adı</th>
                                        <th class="w-20">Ülke Adı</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($states as $state)
                                        <tr>
                                            <td>
                                                @if ($state->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($state->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($state->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $state->title }}</td>
                                            <td>{{ $state->country->title }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.settings.locations.state.edit', $state->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Düzenle">
                                                    Düzenle
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
    </div>
@endsection
