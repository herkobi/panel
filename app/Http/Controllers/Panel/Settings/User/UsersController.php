<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Settings\User;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Settings\Roles\AssignUserRoleRequest;
use App\Http\Requests\Panel\Settings\User\ChangeUserEmailRequest;
use App\Http\Requests\Panel\Settings\User\CreateUserRequest;
use App\Http\Requests\Panel\Settings\User\UpdateUserStatusRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Settings\User\UserResource;
use App\Http\Resources\Panel\Settings\User\UserSessionResource;
use App\Http\Resources\Panel\Tools\Activity\ActivityResource;
use App\Models\User;
use App\Services\Panel\Settings\Roles\RoleService;
use App\Services\Panel\Settings\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(Request $request, UserService $service): Response
    {
        $filters = [
            'q' => $request->string('q')->toString(),
        ];

        return Inertia::render('panel/settings/users/index', [
            'users' => PaginatedResource::make($service->paginate($filters), UserResource::class, $request),
            'filters' => $filters,
        ]);
    }

    public function create(Request $request, RoleService $roleService): Response
    {
        /** @var User $causer */
        $causer = $request->user();

        return Inertia::render('panel/settings/users/create', [
            'statuses' => collect(UserStatus::cases())
                ->map(fn (UserStatus $status): array => [
                    'value' => $status->value,
                    'label' => $status->label(),
                ])
                ->values(),
            'roles' => $roleService->assignableRolesFor($causer)
                ->map(fn ($role): array => [
                    'name' => $role->name,
                ])
                ->values(),
        ]);
    }

    public function store(CreateUserRequest $request, UserService $service): RedirectResponse
    {
        /** @var User $causer */
        $causer = $request->user();

        $user = $service->create($request->validated(), $causer);

        return to_route('panel.settings.users.show', $user)
            ->with('toast', [
                'type' => 'success',
                'message' => __('Kullanıcı oluşturuldu ve hoş geldin e-postası gönderildi.'),
            ]);
    }

    public function show(Request $request, User $user, UserService $service, RoleService $roleService): Response
    {
        $this->ensurePanelUser($user);

        /** @var User $causer */
        $causer = $request->user();

        return Inertia::render('panel/settings/users/show', [
            'user' => UserResource::make($user),
            'activities' => ActivityResource::collection($service->activities($user)),
            'sessions' => UserSessionResource::collection($service->authentications($user)),
            'assignableRoles' => $roleService->assignableRolesFor($causer)
                ->map(fn ($role): array => [
                    'name' => $role->name,
                ])
                ->values(),
        ]);
    }

    public function updateRole(AssignUserRoleRequest $request, User $user, RoleService $roleService): RedirectResponse
    {
        $this->ensurePanelUser($user);

        /** @var User $causer */
        $causer = $request->user();

        $roleService->assignToUser($user, $causer, (string) $request->validated('role'));

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Kullanıcı rolü güncellendi.'),
        ]);
    }

    public function verifyEmail(Request $request, User $user, UserService $service): RedirectResponse
    {
        $this->ensurePanelUser($user);

        /** @var User $causer */
        $causer = $request->user();

        $service->verifyEmail($user, $causer);

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('E-posta adresi onaylandı.'),
        ]);
    }

    public function requestEmailChange(ChangeUserEmailRequest $request, User $user, UserService $service): RedirectResponse
    {
        $this->ensurePanelUser($user);

        /** @var User $causer */
        $causer = $request->user();

        $service->requestEmailChange($user, $causer, (string) $request->validated('email'));

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('E-posta değişikliği onay bağlantısı gönderildi.'),
        ]);
    }

    public function confirmEmailChange(Request $request, User $user, UserService $service): RedirectResponse
    {
        $this->ensurePanelUser($user);

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

    public function acceptWelcome(Request $request, User $user, UserService $service): RedirectResponse
    {
        $this->ensurePanelUser($user);

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

    public function updateStatus(UpdateUserStatusRequest $request, User $user, UserService $service): RedirectResponse
    {
        $this->ensurePanelUser($user);

        /** @var User $causer */
        $causer = $request->user();

        $service->updateStatus(
            $user,
            $causer,
            UserStatus::from((string) $request->validated('status')),
        );

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Kullanıcı durumu güncellendi.'),
        ]);
    }

    private function ensurePanelUser(User $user): void
    {
        abort_unless($user->user_type === UserType::Admin, 404);
    }
}
