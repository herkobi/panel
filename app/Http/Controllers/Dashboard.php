<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Dashboard extends Controller
{
    public function index(): View
    {
        return view('index');
    }
}
