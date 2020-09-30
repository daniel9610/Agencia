<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $campanias = Campania::all();
            // dd($campanias);
        return view('home', compact('campanias'));
    }
}
