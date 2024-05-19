<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Tools\AuthLogs\AccountLogs;
use App\Actions\Admin\Tools\AuthLogs\AuthLogs;
use App\Actions\Admin\Tools\AuthLogs\GetUser;
use App\Actions\Admin\Tools\AuthLogs\UserLogs;
use Illuminate\View\View;

class AuthLogsController extends Controller
{
    private $getUser;
    private $accountLogs;
    private $userLogs;
    private $authLogs;

    public function __construct(
        GetUser $getUser,
        AccountLogs $accountLogs,
        UserLogs $userLogs,
        AuthLogs $authLogs
    ) {
        $this->getUser = $getUser;
        $this->accountLogs = $accountLogs;
        $this->userLogs = $userLogs;
        $this->authLogs = $authLogs;
    }

    public function index(): View
    {
        $logs = $this->accountLogs->execute();
        return view("admin.tools.authlogs.accounts", [
            'logs' => $logs
        ]);
    }

    public function users(): View
    {
        $logs = $this->userLogs->execute();
        return view("admin.tools.authlogs.users", [
            'logs' => $logs
        ]);
    }

    public function authLogs($id): View
    {
        $user = $this->getUser->execute($id);
        $authLogs = $this->authLogs->execute($id);
        return view("admin.tools.authlogs.detail", [
            'user' => $user,
            'authLogs' => $authLogs
        ]);
    }

}
