<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Services\Admin\Tools\AuthLogsService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AuthLogsController extends Controller
{
    protected $authLogs;

    public function __construct(AuthLogsService $authLogs)
    {
        $this->authLogs = $authLogs;
    }

    public function index(): View|LengthAwarePaginator
    {
        $logs = $this->authLogs->usersAuthLogs();
        return view('admin.tools.userauthlogs', [
            'logs' => $logs
        ]);
    }

    public function admins(): View|LengthAwarePaginator
    {
        $logs = $this->authLogs->adminsAuthLogs();
        return view('admin.tools.adminauthlogs', [
            'logs' => $logs
        ]);
    }
}
