<?php

namespace App\Http\Controllers;

use Illuminate\View\Factory as View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param \Illuminate\View\Factory $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(View $view)
    {
        return $view->make('pages.home');
    }
}
