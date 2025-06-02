<?php

namespace App\Http\Controllers;
use App\Models\Makanan;

use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index()
    {
        $daftarMakanan = Makanan::all();
        

        return view('makanan', ['daftarMakanan' => $daftarMakanan]);
    }
}
