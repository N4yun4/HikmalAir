<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Pastikan model Booking diimpor
use App\Models\Flight;  // Pastikan model Flight diimpor
use Illuminate\Support\Str; // Diperlukan untuk Str::random()
use Illuminate\Support\Facades\Auth; // Diperlukan untuk Auth::id()
use Carbon\Carbon; // Diperlukan untuk Carbon::now() atau format tanggal

class BookingController extends Controller
{
    /**
     * Proses pengiriman form pemesanan tiket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processBooking(Request $request)
    {
        // 1. Validasi Input Data Pemesan
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id', // Pastikan ID tiket ada di tabel 'flights'
            'contact_full_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
        ], [
            'ticket_id.required' => 'ID tiket tidak ditemukan.',
            'ticket_id.exists' => 'Tiket yang Anda pilih tidak valid.',
            'contact_full_name.required' => 'Nama lengkap pemesan wajib diisi.',
            'contact_email.required' => 'Alamat email wajib diisi.',
            'contact_email.email' => 'Format alamat email tidak valid.',
            'contact_phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        // 2. Ambil Detail Penerbangan untuk mendapatkan harga dan informasi lain
        $flight = Flight::findOrFail($validatedData['ticket_id']);

        // 3. Buat Kode Pemesanan Unik
        $bookingCode = 'HKM' . Str::upper(Str::random(7)); // Contoh: HKMABCDEFG
        while (Booking::where('booking_code', $bookingCode)->exists()) {
            $bookingCode = 'HKM' . Str::upper(Str::random(7));
        }

        // 4. Simpan Data Pemesanan ke Database
        $booking = Booking::create([
            'user_id' => Auth::id(), // Mengambil ID pengguna yang sedang login (akan NULL jika tidak login)
            'flight_id' => $flight->id,
            'booking_code' => $bookingCode,
            'passenger_full_name' => $validatedData['contact_full_name'],
            'passenger_email' => $validatedData['contact_email'],
            'passenger_phone' => $validatedData['contact_phone'],
            'total_price' => $flight->price_int, // Menggunakan harga integer dari model Flight
            'booking_status' => 'pending',        // Status awal pemesanan
            'payment_status' => 'pending',        // Status awal pembayaran
            'payment_method' => null,             // Metode pembayaran akan diisi setelah proses pembayaran, kita sudah set NULLABLE di DB
            'booked_at' => now(),                 // Menggunakan waktu saat ini
        ]);

        // 5. Redirect ke Halaman Konfirmasi dengan data pemesanan
        return redirect()->route('booking.confirmation', ['booking_code' => $booking->booking_code])
                         ->with('success', 'Pemesanan Anda berhasil dibuat!');
    }

    /**
     * Menampilkan halaman konfirmasi pemesanan.
     *
     * @param  string  $booking_code
     * @return \Illuminate\Http\Response
     */
    public function confirmation($booking_code)
    {
        // Temukan pemesanan berdasarkan kode booking dan eager load relasi 'flight'
        $booking = Booking::where('booking_code', $booking_code)->with('flight')->firstOrFail();

        // Ambil data penerbangan dari objek booking.
        $flight = $booking->flight;

        // Persiapkan variabel $selectedTicket berdasarkan data $flight
        $selectedTicket = [
            'airline_name' => $flight->airline_name,
            'flight_number' => 'HA-' . $flight->id, // Ganti dengan $flight->flight_number jika ada di DB
            'flight_class' => $flight->flight_class,
            'departure_city' => $flight->departure_city,
            'departure_code' => $flight->departure_code,
            'arrival_city' => $flight->arrival_city,
            'arrival_code' => $flight->arrival_code,
            'formatted_date' => $flight->date->translatedFormat('D, d M Y'),
            'departure_time' => $flight->departure_time,
            'arrival_time' => $flight->arrival_time,
            'duration' => $flight->duration,
            'price_display' => $flight->price_display,
            'price_int' => $flight->price_int,
        ];

        // Persiapkan variabel $bookerDetails dari data $booking
        $bookerDetails = [
            'contact_full_name' => $booking->passenger_full_name,
            'contact_email' => $booking->passenger_email,
            'contact_phone' => $booking->passenger_phone,
        ];

        // Siapkan data untuk add-ons (dummy atau dari DB jika sudah diimplementasikan)
        $addOnPrices = [
            'insurance' => 55000,
            'baggage' => [
                '10kg' => 120000, '20kg' => 220000, '30kg' => 300000, '40kg' => 380000
            ],
            'pickup' => [
                'motor' => 60000, 'mobil_kecil' => 130000, 'mobil_besar' => 200000
            ]
        ];

        // Siapkan data untuk makanan dan hotel (dummy atau dari DB jika sudah diimplementasikan)
        $selectedMealsDetails = null;
        $selectedHotelDetails = null;

        // Kirim semua variabel yang dibutuhkan ke view 'konfirmasi'.
        return view('konfirmasi', compact(
            'booking',
            'selectedTicket',
            'bookerDetails',
            'addOnPrices',
            'selectedMealsDetails',
            'selectedHotelDetails'
        ));
    }
}