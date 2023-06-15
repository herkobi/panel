@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Başlangıç'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Son İşlemler</h4>
                        </div>
                        <div class="card-body">
                            {{\Spatie\Activitylog\Contracts\Activity::all()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
