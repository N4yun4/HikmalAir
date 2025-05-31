<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight; // Import model Flight Anda
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
        // Temukan tiket berdasarkan ID.
        // Jika tidak ditemukan, Laravel akan secara otomatis menampilkan halaman 404.
        $ticket = Flight::findOrFail($id);

        // Karena 'departure_time' dan 'arrival_time' di-cast sebagai 'datetime:H:i'
        // di model, mereka akan otomatis menjadi objek Carbon.
        // Anda bisa mengakses komponen waktu langsung.
        // Untuk harga, kita sudah punya price_display di model, jadi tidak perlu format ulang.

        return view('deskripsitiket', compact('ticket'));
    }

    // Anda bisa menghapus method getDummyTicket() karena tidak lagi dibutuhkan
    // jika Anda mengambil data langsung dari database.
}