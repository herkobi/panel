<div class="page-title position-relative pt-3 pb-4">
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="fw-semibold text-white mb-0">{{ $title }}</h1>
    </div>
    @if (!empty($status))
        <span class="badge text-bg-light"> {{ $status }} </span>
    @endif
</div>
