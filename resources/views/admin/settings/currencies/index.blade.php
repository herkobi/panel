@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Para Birimleri',
                ])
                @include('admin.settings.currencies.partials.page-buttons', [
                    'first_button' => 'Para Birimleri',
                    'first_link' => 'panel.settings.currencies',
                    'second_button' => 'Yeni Para Birimi Ekle',
                    'second_link' => 'panel.settings.currency.create',
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
                            <h1 class="card-title">Para Birimleri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-40">Para Birimi</th>
                                        <th class="w-20">Sembol</th>
                                        <th class="w-20">Kod</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currencies as $currency)
                                        <tr>
                                            <td>
                                                @if ($currency->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($currency->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($currency->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $currency->title }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>{{ $currency->code }}</td>
                                            <td class="text-center">
                                                @if (auth()->user()->can('currency.update'))
                                                    <a href="{{ route('panel.settings.currency.edit', $currency->id) }}"
                                                        class="btn btn-ghost-primary btn-sm" title="Düzenle">
                                                        Düzenle
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $currencies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
