@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Yönetici Uygulama Kayıtları'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-9">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Yönetici Hareketleri</h4>
                            <small>Yöneticilerin uygulama içerisinde yapmış olduğu işlemler</small>
                        </div>
                        <div class="card-body">
                            @foreach ($activities as $activity)
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl bg-success"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content border-bottom bounce-in">
                                                <h4 class="timeline-title"></h4>
                                                <p>{{ $activity->description }}</p>
                                                <span
                                                    class="vertical-timeline-element-date">{{ $activity->created_at->format('d-m-Y') }}<br>{{ $activity->created_at->format('H:i:s') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            {{ $activities->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h4 class="card-title mb-0">Kullanıcı Ara</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-group custom-input-group">
                                <input type="text" class="form-control rounded-0 shadow-none" placeholder="Kullanıcı Adı"
                                    aria-label="Kullanıcı Ara" aria-describedby="button-search" id="searchText">
                                <button class="btn btn-outline-secondary rounded-0 shadow-none border-left-0" type="button"
                                    id="button-search"><i class="ri-search-2-line"></i></button>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="card rounded-0 shadow-sm border-0 mb-3">
                            <div class="card-header border-0 bg-white pt-3 pb-0">
                                <h4 class="card-title mb-0">Eylem</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($events as $event)
                                        <li class="list-group-item bg-white">
                                            <div class="form-check">
                                                <input class="form-check-input rounded-0 shadow-none status" type="checkbox"
                                                    name="event[]" value="create"
                                                    id="user-status-select-{{ $event }}" onclick="checkEvent(this)">
                                                <label class="form-check-label"
                                                    for="user-status-select-{{ $event }}">{{ $event }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card rounded-0 shadow-sm border-0 mb-3">
                            <div class="card-header border-0 bg-white pt-3 pb-0">
                                <h4 class="card-title mb-0">Modül</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($models as $key => $model)
                                        <li class="list-group-item bg-white">
                                            <div class="form-check">
                                                <input class="form-check-input rounded-0 shadow-none status" type="checkbox"
                                                    name="model[]" value="{{ $model }}"
                                                    id="user-status-select-{{ $key }}" onclick="checkModel(this)">
                                                <label class="form-check-label"
                                                    for="user-status-select-{{ $key }}">{{ $model }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
