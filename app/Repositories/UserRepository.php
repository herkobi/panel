<?php

namespace App\Repositories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function getAllUsers(): Collection
    {
        return User::whereIn('type', [UserType::SUPER->value, UserType::ADMIN->value])->get();
    }

    public function getAccounts(): Collection
    {
        return User::where('type', [UserType::USER])->get();
    }

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->model::create([
                'status' => isset($data['status']) ? AccountStatus::ACTIVE : AccountStatus::PASSIVE,
                'type' => UserType::ADMIN,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'terms' => 1,
                'password' => Hash::make($data['password']),
                'email_verified_at' => isset($data['verifyemail']) ? Carbon::now()->toDateTimeString() : null,
                'created_by' => Auth::id(),
                'created_by_name' => Auth::user()->name . ' ' . Auth::user()->surname,
            ]);

            $folderName = 'user_' . Str::random(12);

            if (!Storage::disk('public')->exists($folderName)) {
                Storage::disk('public')->makeDirectory($folderName);
            }

            $user->meta()->create([
                'title' => $data['title'] ?? null,
                'url' => '',
                'phone' => '',
                'user_folder' => $folderName
            ]);

            return $user;
        });
    }

    public function updateProfile(string $id, array $data): User|Model
    {
        $user = $this->getById($id);
        $user->update([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'title' => $data['title']
        ]);

        return $user;
    }

    public function updateStatus(string $id, array $data): User|Model|null
    {
        $user = $this->getById($id);
        foreach (AccountStatus::cases() as $accountStatus) {
            if ($accountStatus->value == $data['status']) {
                $status = $accountStatus->value;
            }
        }

        $user->update([
            'status' => $status
        ]);

        return $user;
    }

    public function updateEmail(string $id, array $data): ?User
    {
        $user = $this->getById($id);
        if ($data['email'] === $user->email && !($user instanceof MustVerifyEmail)) {
            return null;
        }

        $user->update([
            'email' => $data['email'],
            'email_verified_at' => null
        ]);

        return $user;
    }

    public function verifyEmail(string $id, array $data): ?User
    {
        $user = $this->getById($id);
        if ($data['email'] === $user->email && !($user instanceof MustVerifyEmail)) {
            return null;
        }

        $user->sendEmailVerificationNotification();
        return $user;
    }

    public function checkEmail(string $id, array $data): User|Model|null
    {
        $user = $this->getById($id);
        if ($data['email'] !== $user->email) {
            return null;
        }

        $user->update([
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ]);

        return $user;
    }

    public function updatePassword(string $id, array $data): User|Model
    {
        $user = $this->getById($id);
        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        return $user;
    }

    public function resetPassword(string $id, array $data): array
    {
        $user = $this->getById($id);
        $status = Password::sendResetLink(['email' => $data["email"]]);
        return ['status' => $status, 'user' => $user];
    }

    public function getUserActivity(string $id): LengthAwarePaginator
    {
        $user = $this->getById($id);
        return $user->activities()->orderBy('created_at', 'desc')->paginate(40);
    }
}
