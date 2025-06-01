<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use Carbon\Carbon;

class PilihTiketController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input pencarian
        $dari = $request->input('dari');
        $ke = $request->input('ke');
        $tanggalBerangkat = $request->input('tanggal_berangkat');
        $pulangPergi = $request->boolean('pulang_pergi');
        $tanggalPulang = $request->input('tanggal_pulang');

        // Mulai query dari model Flight
        $flightsQuery = Flight::query();

        // Terapkan filter berdasarkan input - PENCARIAN YANG LEBIH FLEKSIBEL
        if (!empty($dari)) {
            $flightsQuery->where(function($query) use ($dari) {
                $query->where('departure_code', 'LIKE', '%' . strtoupper($dari) . '%')
                ->orWhere('departure_city', 'LIKE', '%' . $dari . '%');
            });
        }

        if (!empty($ke)) {
            $flightsQuery->where(function($query) use ($ke) {
                $query->where('arrival_code', 'LIKE', '%' . strtoupper($ke) . '%')
                ->orWhere('arrival_city', 'LIKE', '%' . $ke . '%');
            });
        }

        if (!empty($tanggalBerangkat)) {
            $flightsQuery->whereDate('date', $tanggalBerangkat);
        }

        // Ambil hasil tiket yang sudah difilter
        $flights = $flightsQuery->get();

        // Pencarian tiket pulang dengan logika yang sama
        $returnFlights = collect();
        if ($pulangPergi && !empty($tanggalPulang) && !empty($ke) && !empty($dari)) {
            $returnFlightsQuery = Flight::query();

            // Untuk tiket pulang, balik dari dan ke
            $returnFlightsQuery->where(function($query) use ($ke) {
                $query->where('departure_code', 'LIKE', '%' . strtoupper($ke) . '%')
                ->orWhere('departure_city', 'LIKE', '%' . $ke . '%');
            });

            $returnFlightsQuery->where(function($query) use ($dari) {
                $query->where('arrival_code', 'LIKE', '%' . strtoupper($dari) . '%')
                ->orWhere('arrival_city', 'LIKE', '%' . $dari . '%');
            });

            $returnFlightsQuery->whereDate('date', $tanggalPulang);
            $returnFlights = $returnFlightsQuery->get();
        }

        return view('pilihtiket', [
            'tickets' => $flights,
            'returnTickets' => $returnFlights,
            'searchParams' => $request->all()
        ]);
    }

    public function showDeskripsi($id)
    {
        $ticket = Flight::find($id);

        if (!$ticket) {
            abort(404, 'Detail tiket yang Anda cari tidak ditemukan.');
        }

        return view('deskripsitiket', [
            'ticket' => $ticket
        ]);
    }
}
