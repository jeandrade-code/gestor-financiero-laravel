<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index(): View
    {
        return view('landing');
    }
}
