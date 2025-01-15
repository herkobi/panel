<?php

namespace App\Repositories;

use App\Enums\AccountStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Agreement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function getAllUsers(): Collection
    {
        return User::where('type', UserType::ADMIN->value)->get();
    }

    public function getAccounts(): Collection
    {
        return User::where('type', UserType::USER->value)
                   ->where('status', AccountStatus::ACTIVE->value)
                   ->get();
    }

    public function withMeta(string $id): User
    {
        return User::with('meta')->findOrFail($id);
    }

    public function withActivities(string $id): User
    {
        return User::with('activities')->findOrFail($id);
    }

    public function withAuthLogs(string $id): User
    {
        return User::with('authlogs')->findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->model::create([
                'status' => !isset($data['status']) ? AccountStatus::ACTIVE : AccountStatus::PASSIVE,
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
                'user_folder' => $folderName
            ]);

            // Yönetici sözleşmelerini imzala
            $agreements = Agreement::where('user_type', UserType::ADMIN)
                ->where('status', Status::ACTIVE)
                ->where('show_on_register', true)
                ->get();

            foreach ($agreements as $agreement) {
                $latestVersion = $agreement->latestVersion();
                if ($latestVersion) {
                    $user->agreements()->attach($agreement->id, [
                        'id' => Str::uuid(),
                        'agreement_version_id' => $latestVersion->id,
                        'accepted_at' => now(),
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent()
                    ]);
                }
            }

            return $user;
        });
    }

    public function createAccount(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->model::create([
                'status' => !isset($data['status']) ? AccountStatus::ACTIVE : AccountStatus::PASSIVE,
                'type' => UserType::USER,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
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
                'user_folder' => $folderName
            ]);

            $user->account()->create([
                'invoiceName' => $user->name . ' ' . $user->surname,
                'taxOffice' => null,
                'taxNumber' => null,
                'address' => null,
                'zipCode' => null,
                'state' => null,
                'city' => null,
                'country' => null,
                'mersis' => null,
                'phone' => null,
                'email' => $user->email,
                'kep' => null,
            ]);

            // Kullanıcı sözleşmelerini imzala
            $agreements = Agreement::where('user_type', UserType::USER)
                ->where('status', Status::ACTIVE)
                ->where('show_on_register', true)
                ->get();

            foreach ($agreements as $agreement) {
                $latestVersion = $agreement->latestVersion();
                if ($latestVersion) {
                    $user->agreements()->attach($agreement->id, [
                        'id' => Str::uuid(),
                        'agreement_version_id' => $latestVersion->id,
                        'accepted_at' => now(),
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent()
                    ]);
                }
            }

            return $user;
        });
    }

    public function updateProfile(string $id, array $data): User|Model
    {
        $user = $this->getById($id);
        $user->update([
            'name' => $data['name'],
            'surname' => $data['surname'],
        ]);

        $user->meta()->update([
            'title' => $data['title'] ?? null,
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

    public function resetPassword(string $id, array $data): array
    {
        $user = $this->getById($id);
        $status = Password::sendResetLink(['email' => $data["email"]]);
        return ['status' => $status, 'user' => $user];
    }

    public function updatePassword(string $id, array $data): User|Model
    {
        $user = $this->getById($id);

        // Eski şifre kontrolü
        if (!Hash::check($data['old_password'], $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Mevcut şifreniz doğru değil.'
            ]);
        }

        // Yeni şifre eski şifre ile aynı olmamalı
        if (Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Yeni şifreniz eski şifrenizden farklı olmalıdır.'
            ]);
        }

        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        return $user;
    }
}
