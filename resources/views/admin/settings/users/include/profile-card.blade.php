<div class="profile-card mb-5">
    <div class="profile-info">
        <h3 class="w-100 mb-1">{{ $user->name . ' ' . $user->surname }}</h3>
        <div class="user-meta">
            @if ($user->status->value == 1)
                <span
                    class="badge bg-success small">{{ AccountStatus::fromValue($user->status->value)?->title() ?? 'Unknown Status' }}</span>
            @else
                <span
                    class="badge bg-danger small">{{ AccountStatus::fromValue($user->status->value)?->title() ?? 'Unknown Status' }}</span>
            @endif
            @if ($user->type->value == 1)
                <span
                    class="badge bg-primary small">{{ UserType::fromValue($user->type->value)?->title() ?? 'Unknown Type' }}</span>
            @else
                <span
                    class="badge bg-info small">{{ UserType::fromValue($user->type->value)?->title() ?? 'Unknown Type' }}</span>
            @endif
        </div>
    </div>
</div>
