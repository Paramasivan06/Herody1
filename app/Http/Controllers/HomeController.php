<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaleForm;


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
        return redirect()->route('user.dashboard');
    }
    public function digital()
    {
        return redirect()->route('digital');
    }
    public function gigworkers()
    {
        return redirect()->route('gigworkers');
    }
    public function businesses()
    {
        return redirect()->route('businesses');
    }
    public function sale()
    {
        return redirect()->route('sale');
    }
     
    
}
