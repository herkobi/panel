@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Başlangıç',
    ])
    <div class="page-content mt-3">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-3 mb-1">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <span class="fw-medium mb-3">Aylık Abone Sayısı</span>
                            <div id="aylik-abone-sayisi">
                                <table class="charts-css area hide-data">
                                    <caption> Aylık Abone Sayısı </caption>
                                    <tbody>
                                        <tr>
                                            <td style="--start: 0.2; --end: 0.4;"><span class="data"> $ 40K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.4; --end: 0.8;"><span class="data"> $ 80K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.8; --end: 0.6;"><span class="data"> $ 60K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.6; --end: 1.0;"><span class="data"> $ 100K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 1.0; --end: 0.3;"><span class="data"> $ 30K </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <span class="fw-medium">Toplam Abone Sayısı</span>
                            <div id="toplam-abone-sayisi">
                                <table class="charts-css area hide-data">
                                    <caption> Toplam Abone Sayısı </caption>
                                    <tbody>
                                        <tr>
                                            <td style="--start: 0.2; --end: 0.4;"><span class="data"> $ 40K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.4; --end: 0.8;"><span class="data"> $ 80K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.8; --end: 0.6;"><span class="data"> $ 60K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.6; --end: 1.0;"><span class="data"> $ 100K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 1.0; --end: 0.3;"><span class="data"> $ 30K </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <span class="fw-medium">Aylık Gelir</span>
                            <div id="aylik-gelir">
                                <table class="charts-css area hide-data">
                                    <caption> Aylık Gelir </caption>
                                    <tbody>
                                        <tr>
                                            <td style="--start: 0.2; --end: 0.4;"><span class="data"> $ 40K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.4; --end: 0.8;"><span class="data"> $ 80K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.8; --end: 0.6;"><span class="data"> $ 60K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.6; --end: 1.0;"><span class="data"> $ 100K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 1.0; --end: 0.3;"><span class="data"> $ 30K </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <span class="fw-medium">Toplam Gelir</span>
                            <div id="toplam-gelir">
                                <table class="charts-css area hide-data">
                                    <caption> Toplam Gelir </caption>
                                    <tbody>
                                        <tr>
                                            <td style="--start: 0.2; --end: 0.4;"><span class="data"> $ 40K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.4; --end: 0.8;"><span class="data"> $ 80K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.8; --end: 0.6;"><span class="data"> $ 60K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 0.6; --end: 1.0;"><span class="data"> $ 100K </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="--start: 1.0; --end: 0.3;"><span class="data"> $ 30K </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-6">
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-6">
                            <h2>Yaklaşan Abonelikler</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="w-30">Hesap Adı</th>
                                    <th class="w-20">Plan Adı</th>
                                    <th class="w-30">Başlangıç - Bitiş Tarihi</th>
                                    <th class="w-20">Ödeme Bilgisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-6">
                            <h2>Yeni Abonelikler</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="w-30">Hesap Adı</th>
                                    <th class="w-20">Plan Adı</th>
                                    <th class="w-30">Başlangıç - Bitiş Tarihi</th>
                                    <th class="w-20">Ödeme Bilgisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                                <tr>
                                    <td>Bülent Sakarya</td>
                                    <td>Standart</td>
                                    <td>15.10.2024 - 15.11.2024</td>
                                    <td><span class="badge bg-danger">ÖDENDİ</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
