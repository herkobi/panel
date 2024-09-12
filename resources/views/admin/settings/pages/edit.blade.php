@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                    @include('admin.settings.include.navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Sayfalar</h1>
                            <a href="{{ route('panel.settings.page.create') }}"
                                class="btn btn-primary btn-sm rounded-sm">Yeni Sayfa</a>
                        </div>
                    </div>
                    <form action="{{ route('panel.settings.page.update', $page->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-lg-2 col-md-3 col-form-label required">Durum</label>
                                <div class="col-lg-10 col-md-9">
                                    <div>
                                        @foreach (Status::cases() as $type)
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status"
                                                    value="{{ $type->value }}"
                                                    {{ $type->value == $page->status->value ? 'checked' : '' }}>
                                                <span class="form-check-label">{{ Status::getTitle($type->value) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-2 col-md-3 col-form-label required">Yazı Başlığı</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $page->title) }}" placeholder="Yazı Başlığı" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <small class="form-hint">Lütfen yazı başlığını giriniz.</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-lg-2 col-md-3 col-form-label required">Yazı İçeriği</label>
                                <div class="col-lg-10 col-md-9">
                                    <textarea id="editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="6"
                                        placeholder="Yazı İçeriği" required>{{ old('content', $page->content) }}</textarea>
                                    @error('text')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <small class="form-hint">Lütfen yazı içeriğini giriniz.</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="row">
                                <div class="col-lg-10 offset-lg-2 col-md-9 offset-md-3">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <button type="submit" class="btn btn-success">GÜNCELLE</button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">SİL</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('panel.settings.page.delete', $page->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Dikkat!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <strong>{{ $page->title }}</strong> isimli sayfayı silmek üzeresiniz. Bu işlem geri alınamaz. Emin
                        misiniz?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">İptal
                            Et</button>
                        <button type="submit" class="btn btn-sm btn-danger">Evet, Sayfayı Sil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
