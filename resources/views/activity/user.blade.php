@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Kullanıcı Uygulama Kayıtları'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Kullanıcı Hareketleri</h4>
                            <small>Kullanıcıların uygulama içerisinde yapmış olduğu işlemler</small>
                        </div>
                        <div class="card-body">
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <span class="vertical-timeline-element-icon bounce-in">
                                            <i class="badge badge-dot badge-dot-xl bg-success"> </i>
                                        </span>
                                        <div class="vertical-timeline-element-content border-bottom bounce-in">
                                            <h4 class="timeline-title">Başarılı Ödeme</h4>
                                            <p>Paket ödemesi başarılı bir şekilde gerçekleşti</p>
                                            <span class="vertical-timeline-element-date">12 Ağustos
                                                2022<br>15:30:45</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
