<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use Carbon\Carbon;

class DeskripsiTiketController extends Controller
{
    /**
     * Display the specified ticket description.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Flight::findOrFail($id);

        return view('deskripsitiket', compact('ticket'));
    }
}