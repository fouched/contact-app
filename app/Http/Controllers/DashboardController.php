<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['auth']);
//    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request)
    {
        return view('dashboard');
    }
}
