@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Profil Bilgileri',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profil Bilgileri</h4>
                            <div class="list-group list-group-transparent">
                                @include('admin.profile.partials.navigation')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <div class="row g-0 mb-3">
                                <form class="card border-0 rounded-none">
                                    <div class="card-header px-0 pt-0">
                                        <h2 class="card-title">Kişisel Bilgiler</h2>
                                    </div>
                                    <div class="card-body px-0">
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required">Email address</label>
                                            <div class="col">
                                                <input type="email" class="form-control" aria-describedby="emailHelp"
                                                    placeholder="Enter email">
                                                <small class="form-hint">We'll never share your email with anyone
                                                    else.</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required">Password</label>
                                            <div class="col">
                                                <input type="password" class="form-control" placeholder="Password">
                                                <small class="form-hint">
                                                    Your password must be 8-20 characters long, contain letters and numbers,
                                                    and must not contain
                                                    spaces, special characters, or emoji.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label">Select</label>
                                            <div class="col">
                                                <select class="form-select">
                                                    <option>Option 1</option>
                                                    <optgroup label="Optgroup 1">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                    </optgroup>
                                                    <option>Option 2</option>
                                                    <optgroup label="Optgroup 2">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                    </optgroup>
                                                    <optgroup label="Optgroup 3">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                    </optgroup>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-3 col-form-label pt-0">Checkboxes</label>
                                            <div class="col">
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" checked="">
                                                    <span class="form-check-label">Option 1</span>
                                                </label>
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                    <span class="form-check-label">Option 2</span>
                                                </label>
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled="">
                                                    <span class="form-check-label">Option 3</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer px-0 text-end">
                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
