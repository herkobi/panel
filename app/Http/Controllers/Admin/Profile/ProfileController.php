<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Services\Admin\Profile\ProfileService;
use App\Traits\AuthUser;
use Illuminate\View\View;

class ProfileController extends Controller
{

    use AuthUser;

    protected $userService;

    public function __construct(ProfileService $userService)
    {
        $this->userService = $userService;
        $this->initializeAuthUser();
    }

    public function index(): View
    {
        $profile = $this->userService->getById($this->user->id);
        return view('admin.profile.index', [
            'profile' => $profile
        ]);
    }

 }
