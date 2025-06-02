<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Booking;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    // Tampilkan daftar makanan
    public function index(Request $request)
    {
        $booking_code = $request->query('booking_code');
        $booking = Booking::where('booking_code', $booking_code)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking tidak valid!');
        }

        $daftarMakanan = Makanan::all();
        // dd($daftarMakanan);

        return view('makanan', [
            'daftarMakanan' => $daftarMakanan,
            'booking_code' => $booking_code // Kirim ini ke view
        ]);
    }

    public function simpanSementara(Request $request)
    {
        $request->validate([
            'selectedMeals' => 'required|array',
            'selectedMeals.*' => 'integer|min:1',
            'booking_code' => 'required|exists:bookings,booking_code' // Ubah ini
        ]);

        // Simpan makanan yang dipilih ke booking
        $booking = Booking::where('booking_code', $request->booking_code)->first();

        if ($booking) {
            $booking->selected_meals = $request->selectedMeals;
            $booking->save();

            return redirect()->route('booking.confirmation', ['booking_code' => $booking->booking_code])
                            ->with('success', 'Makanan berhasil ditambahkan!');
        }

        return back()->with('error', 'Booking tidak ditemukan!');
    }
}
