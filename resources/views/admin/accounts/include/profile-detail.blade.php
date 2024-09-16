<div class="profile-detail">
    <div class="datagrid position-relative w-100">
        <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
            <div class="datagrid-title">Ad Soyad</div>
            <div class="datagrid-content">
                {{ $user->name . ' ' . $user->surname }}
            </div>
        </div>
        @if (!empty($user->meta->title))
            <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
                <div class="datagrid-title">Görev</div>
                <div class="datagrid-content">
                    {{ $user->meta->title }}
                </div>
            </div>
        @endif
        <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
            <div class="datagrid-title">E-posta Adresi</div>
            <div class="datagrid-content">
                {{ $user->email }}
            </div>
        </div>
        <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
            <div class="datagrid-title">Son Oturum Tarihi</div>
            <div class="datagrid-content">{{ $user->last_login_at }}</div>
        </div>
        <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
            <div class="datagrid-title">Son Oturum IP Adresi</div>
            <div class="datagrid-content">{{ $user->last_login_ip }}</div>
        </div>
        <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
            <div class="datagrid-title">Hesap Açılış Tarihi</div>
            <div class="datagrid-content">{{ $user->created_at }}</div>
        </div>
        <div class="datagrid-item d-flex align-items-start justify-content-between border-bottom mb-2 pb-1">
            <div class="datagrid-title">Hesabı Oluşturan Kişi</div>
            <div class="datagrid-content">{{ $user->created_by_name }}</div>
        </div>
    </div>
</div>
