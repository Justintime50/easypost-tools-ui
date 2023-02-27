<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application index.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        return view('app');
    }

    /**
     * Show the application account page.
     *
     * @param Request $request
     * @return View
     */
    public function account(Request $request): View
    {
        return view('account');
    }
}
