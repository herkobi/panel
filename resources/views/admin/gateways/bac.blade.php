@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Ödeme Yöntemleri',
                ])
                @include('admin.settings.payments.partials.page-buttons', [
                    'first_button' => 'Ödeme Yöntemleri',
                    'first_link' => 'panel.settings.payments',
                    'second_button' => 'Yeni Hesap Bilgisi Ekle',
                    'second_link' => 'panel.gateways.bac.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.payments.partials.payments')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">EFT/Havale Ödeme Bilgileri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-60">Ödeme Yöntemi</th>
                                        <th class="w-20">Para Birimi</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gateways as $gateway)
                                        <tr>
                                            <td>
                                                @if ($gateway->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($gateway->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($gateway->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $gateway->title }}</div>
                                                <div class="word-wrap">{{ $gateway->desc }}</div>
                                            </td>
                                            <td>{{ $gateway->currency->title }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.gateways.bac.edit', $gateway->id) }}"
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
                            {{ $gateways->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
