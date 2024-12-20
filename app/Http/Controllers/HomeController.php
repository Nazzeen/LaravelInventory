<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth');    //AUTOMATICALLY GO LOGIN */
    }

    public function homepages()
    {
        return view('homepage');
    }

    public function mainIndexs()
    {
        return view('mainIndex');
    }

    public function registers()
    {
        return view('register');
    }

    public function logins()
    {
        return view('login');
    }


    public function details() // Add this method
    {
        return view('detail');
    }

    public function checkouts()
    {
        return view('checkout');
    }

    public function pays()
    {
        return view('pay');
    }

    /* public function dashboards()
    {
        return view('dashboard');
    } */

}

