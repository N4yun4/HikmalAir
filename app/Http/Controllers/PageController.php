<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function seat(){
        return view('seat');
    }

    public function makanan(){
    return view('makanan');
    }

    public function diskon(){
    return view('diskon');
    }
}
