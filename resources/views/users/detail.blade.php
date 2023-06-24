@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => $user->name])
    <div class="page-content position-relative activity-page mb-4">
    </div>
@endsection
