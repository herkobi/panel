<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontController extends Controller
{

    protected $agreementService;

    public function __construct() {
    }

    public function index(): View
    {
        return view('front.index');
    }
}
