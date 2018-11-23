<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use \App\Models\User;

use \Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('home', [
            'users' => User::get(),
        ]);
    }
}
