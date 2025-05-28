<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DeskripsiTiketController extends Controller
{
    public function index()
    {
        return view('deskripsitiket');
    }
}
