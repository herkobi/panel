<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Members;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Members\ChangeMemberEmailRequest;
use App\Http\Requests\Panel\Members\CreateMemberRequest;
use App\Http\Requests\Panel\Members\UpdateMemberStatusRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Members\MemberResource;
use App\Http\Resources\Panel\Members\MemberSessionResource;
use App\Http\Resources\Panel\Tools\Activity\ActivityResource;
use App\Models\User;
use App\Services\Panel\Members\MemberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MembersController extends Controller
{
    public function index(Request $request, MemberService $service): Response
    {
        $filters = [
            'q' => $request->string('q')->toString(),
        ];

        return Inertia::render('panel/members/index', [
            'users' => PaginatedResource::make($service->paginate($filters), MemberResource::class, $request),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('panel/members/create', [
            'statuses' => collect(UserStatus::cases())
                ->map(fn (UserStatus $status): array => [
                    'value' => $status->value,
                    'label' => $status->label(),
                ])
                ->values(),
        ]);
    }

    public function store(CreateMemberRequest $request, MemberService $service): RedirectResponse
    {
        /** @var User $causer */
        $causer = $request->user();

        $user = $service->create($request->validated(), $causer);

        return to_route('panel.members.show', $user)
            ->with('toast', [
                'type' => 'success',
                'message' => __('Üye oluşturuldu ve hoş geldin e-postası gönderildi.'),
            ]);
    }

    public function show(User $user, MemberService $service): Response
    {
        $this->ensureMember($user);

        return Inertia::render('panel/members/show', [
            'user' => MemberResource::make($user),
            'activities' => ActivityResource::collection($service->activities($user)),
            'sessions' => MemberSessionResource::collection($service->authentications($user)),
        ]);
    }

    public function verifyEmail(Request $request, User $user, MemberService $service): RedirectResponse
    {
        $this->ensureMember($user);

        /** @var User $causer */
        $causer = $request->user();

        $service->verifyEmail($user, $causer);

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('E-posta adresi onaylandı.'),
        ]);
    }

    public function requestEmailChange(ChangeMemberEmailRequest $request, User $user, MemberService $service): RedirectResponse
    {
        $this->ensureMember($user);

        /** @var User $causer */
        $causer = $request->user();

        $service->requestEmailChange($user, $causer, (string) $request->validated('email'));

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('E-posta değişikliği onay bağlantısı gönderildi.'),
        ]);
    }

    public function confirmEmailChange(Request $request, User $user, MemberService $service): RedirectResponse
    {
        $this->ensureMember($user);

        $email = $request->string('email')->toString();

        if ($email === '' || User::query()->where('email', $email)->where('id', '!=', $user->id)->exists()) {
            return redirect()->route('login')->with('toast', [
                'type' => 'error',
                'message' => __('E-posta değişikliği bağlantısı artık geçerli değil.'),
            ]);
        }

        $service->confirmEmailChange($user, $email);

        return redirect()->route('login')->with('toast', [
            'type' => 'success',
            'message' => __('E-posta adresiniz değiştirildi. Yeni adresinizle giriş yapabilirsiniz.'),
        ]);
    }

    public function acceptWelcome(Request $request, User $user, MemberService $service): RedirectResponse
    {
        $this->ensureMember($user);

        $email = $request->string('email')->toString();
        $token = $request->string('token')->toString();

        if ($email === '' || $token === '' || $email !== $user->email) {
            return redirect()->route('login')->with('toast', [
                'type' => 'error',
                'message' => __('Hoş geldin bağlantısı artık geçerli değil.'),
            ]);
        }

        $service->acceptWelcome($user);

        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function updateStatus(UpdateMemberStatusRequest $request, User $user, MemberService $service): RedirectResponse
    {
        $this->ensureMember($user);

        /** @var User $causer */
        $causer = $request->user();

        $service->updateStatus(
            $user,
            $causer,
            UserStatus::from((string) $request->validated('status')),
        );

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Üye durumu güncellendi.'),
        ]);
    }

    private function ensureMember(User $user): void
    {
        abort_unless($user->user_type === UserType::Member, 404);
    }
}
