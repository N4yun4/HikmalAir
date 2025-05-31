<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight; // <-- WAJIB: Impor model Flight Anda
use Carbon\Carbon; // Sudah ada, bagus!

class PilihTiketController extends Controller
{
    // Hapus fungsi getDummyTicketsData() karena kita akan ambil dari database

    public function index(Request $request)
    {
        // Ambil input pencarian
        $dari = strtoupper($request->input('dari'));
        $ke = strtoupper($request->input('ke'));
        $tanggalBerangkat = $request->input('tanggal_berangkat');
        $pulangPergi = $request->boolean('pulang_pergi'); // Mengambil nilai boolean dari checkbox
        $tanggalPulang = $request->input('tanggal_pulang'); // Ambil tanggal pulang

        // Mulai query dari model Flight
        $flightsQuery = Flight::query();

        // Terapkan filter berdasarkan input
        if (!empty($dari)) {
            $flightsQuery->where('departure_code', $dari);
        }

        if (!empty($ke)) {
            $flightsQuery->where('arrival_code', $ke);
        }

        if (!empty($tanggalBerangkat)) {
            // Pastikan format tanggal di database dan input sama (YYYY-MM-DD)
            $flightsQuery->whereDate('date', $tanggalBerangkat);
        }

        // Jika tidak ada filter yang diberikan, tampilkan semua tiket (opsional, tergantung kebutuhan)
        // Atau Anda bisa default ke tidak menampilkan apa-apa jika tidak ada pencarian spesifik
        // if (empty($dari) && empty($ke) && empty($tanggalBerangkat)) {
        //     // Tidak ada filter, ambil semua atau batasi
        //     // $flights = Flight::all(); // Jika ingin menampilkan semua saat tidak ada filter
        //     $flights = collect(); // Jika ingin kosong saat tidak ada filter
        // } else {
        //     $flights = $flightsQuery->get();
        // }

        // Ambil hasil tiket yang sudah difilter
        $flights = $flightsQuery->get(); // Ambil hasil query

        // Jika ada tanggal pulang (untuk pulang-pergi), Anda bisa menambahkan logika pencarian tiket pulang
        $returnFlights = collect(); // Default koleksi kosong
        if ($pulangPergi && !empty($tanggalPulang) && !empty($ke) && !empty($dari)) {
            $returnFlightsQuery = Flight::query()
                                ->where('departure_code', $ke) // Keberangkatan tiket pulang adalah kedatangan tiket pergi
                                ->where('arrival_code', $dari) // Kedatangan tiket pulang adalah keberangkatan tiket pergi
                                ->whereDate('date', $tanggalPulang);
            $returnFlights = $returnFlightsQuery->get();
        }


        // Kirim data tiket ke view
        return view('pilihtiket', [
            'tickets' => $flights, // Ubah nama variabel menjadi 'tickets' agar konsisten dengan view Anda
            'returnTickets' => $returnFlights, // Kirim tiket pulang juga
            'searchParams' => $request->all() // Kirim kembali parameter pencarian untuk mengisi form
        ]);
    }

    // Method untuk menampilkan detail tiket
    public function showDeskripsi($id)
    {
        // Ambil tiket dari database berdasarkan ID
        $ticket = Flight::find($id); // Mencari tiket berdasarkan primary key (id)

        if (!$ticket) {
            abort(404, 'Detail tiket yang Anda cari tidak ditemukan.');
        }

        // Format tanggal menggunakan Carbon (jika diperlukan di view)
        // Karena model Flight sudah meng-cast 'date' sebagai objek Carbon,
        // Anda bisa langsung menggunakannya di view: $ticket->date->format('D, d M Y');
        // $ticket['formatted_date'] = Carbon::parse($ticket['date'])->translatedFormat('D, d M Y'); // Ini bisa dihapus jika sudah di-cast di model

        return view('deskripsitiket', [
            'ticket' => $ticket
        ]);
    }
}