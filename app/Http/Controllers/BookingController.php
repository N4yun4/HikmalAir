<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Makanan;
use App\Models\Hotel;
use App\Models\RoomType; // Pastikan model ini diimpor jika Anda berencana menggunakannya
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman pemilihan kursi.
     * Menerima data dari form deskripsi tiket (GET request).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showSeatSelection(Request $request)
    {
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id',
            'contact_full_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
            // Ini akan menerima JSON string, biarkan tetap string
            'selected_makanan' => 'nullable|json',
            'selected_hotel' => 'nullable|json',
        ], [
            'ticket_id.required' => 'ID tiket tidak ditemukan.',
            'ticket_id.exists' => 'Tiket yang Anda pilih tidak valid.',
            'contact_full_name.required' => 'Nama lengkap pemesan wajib diisi.',
            'contact_email.required' => 'Alamat email wajib diisi.',
            'contact_email.email' => 'Format alamat email tidak valid.',
            'contact_phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        $flight = Flight::findOrFail($validatedData['ticket_id']);

        // --- PERBAIKAN DI SINI ---
        // Biarkan 'selected_makanan' dan 'selected_hotel' tetap sebagai JSON string
        // karena mereka akan diteruskan ke input hidden di form seat.blade.php
        // agar tetap valid JSON saat kembali ke processBooking.
        $selectedMakananJson = $validatedData['selected_makanan'] ?? '[]';
        $selectedHotelJson = $validatedData['selected_hotel'] ?? '[]';
        // --- AKHIR PERBAIKAN ---

        return view('seat', [
            'ticket' => $flight,
            'contact_full_name' => $validatedData['contact_full_name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
            'selected_makanan' => $selectedMakananJson, // Teruskan sebagai JSON string
            'selected_hotel' => $selectedHotelJson,     // Teruskan sebagai JSON string
        ]);
    }

    /**
     * Memproses pemesanan akhir setelah pemilihan kursi.
     * Metode ini sekarang akan menerima 'selected_seats' dari form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function processBooking(Request $request)
    {
        //dd($request->all());
        // Debugging: Lihat semua data yang datang dari form
        // dd($request->all());

        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id',
            'contact_full_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
            'selected_seats' => 'required|json', // Masih menerima 'selected_seats' dari form frontend
            'selected_makanan' => 'nullable|json',
            'selected_hotel' => 'nullable|json',
        ], [
            'ticket_id.required' => 'ID tiket tidak ditemukan.',
            'ticket_id.exists' => 'Tiket yang Anda pilih tidak valid.',
            'contact_full_name.required' => 'Nama lengkap pemesan wajib diisi.',
            'contact_email.required' => 'Alamat email wajib diisi.',
            'contact_email.email' => 'Format alamat email tidak valid.',
            'contact_phone.required' => 'Nomor telepon wajib diisi.',
            'selected_seats.required' => 'Mohon pilih setidaknya satu kursi.',
            'selected_seats.json' => 'Format kursi yang dipilih tidak valid.'
        ]);

        $flight = Flight::findOrFail($validatedData['ticket_id']);

        $bookingCode = 'HKM' . Str::upper(Str::random(7));
        while (Booking::where('booking_code', $bookingCode)->exists()) {
            $bookingCode = 'HKM' . Str::upper(Str::random(7));
        }

        // Dekode JSON string dari request menjadi array PHP
        // Ini tetap diperlukan karena validator 'json' hanya memvalidasi, tidak mengkonversi
        $selectedSeats = json_decode($validatedData['selected_seats'], true);
        $selectedMakanan = json_decode($validatedData['selected_makanan'] ?? '[]', true);
        $selectedHotel = json_decode($validatedData['selected_hotel'] ?? '[]', true);

        $totalPrice = $flight->price_int;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'flight_id' => $flight->id,
            'booking_code' => $bookingCode,
            'passenger_full_name' => $validatedData['contact_full_name'],
            'passenger_email' => $validatedData['contact_email'],
            'passenger_phone' => $validatedData['contact_phone'],
            'seat' => $selectedSeats, // Laravel akan otomatis meng-encode ini ke JSON karena 'array' cast di model
            'selected_meals' => $selectedMakanan, // Laravel akan otomatis meng-encode ini ke JSON karena 'array' cast di model
            'selected_hotel' => $selectedHotel, // Laravel akan otomatis meng-encode ini ke JSON karena 'array' cast di model
            'total_price' => $totalPrice,
            'booking_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => null,
            'booked_at' => now(),
        ]);

        return redirect()->route('booking.confirmation', ['booking_code' => $booking->booking_code])
                            ->with('success', 'Pemesanan Anda berhasil dibuat!');
    }

    /**
     * Menampilkan halaman konfirmasi pemesanan.
     *
     * @param string $booking_code
     * @return \Illuminate\Http\Response
     */
    public function confirmation($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->with('flight')->firstOrFail();

        $flight = $booking->flight;

        // Mendapatkan data langsung sebagai array dari model karena 'array' cast di Booking.php
        $selectedSeats = $booking->seat;
        $selectedMeals = $booking->selected_meals;
        $selectedHotel = $booking->selected_hotel;

        $selectedTicket = [
            'airline_name' => $flight->airline_name,
            'flight_number' => 'HA-' . $flight->id,
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

        $bookerDetails = [
            'contact_full_name' => $booking->passenger_full_name,
            'contact_email' => $booking->passenger_email,
            'contact_phone' => $booking->passenger_phone,
        ];

        $addOnPrices = [
            'insurance' => 55000,
            'baggage' => [
                '10kg' => 120000, '20kg' => 220000, '30kg' => 300000, '40kg' => 380000
            ],
            'pickup' => [
                'motor' => 60000, 'mobil_kecil' => 130000, 'mobil_besar' => 200000
            ]
        ];

        $selectedMakananDetails = null;
        if (!empty($selectedMeals) && is_array($selectedMeals)) {
            $selectedMakananDetails = Makanan::whereIn('id', $selectedMeals)->get();
        }

        $selectedHotelDetails = null;
        // Pastikan $selectedHotel adalah array dan memiliki kunci 'id'
        if (!empty($selectedHotel) && is_array($selectedHotel) && isset($selectedHotel['id'])) {
            $hotel = Hotel::find($selectedHotel['id']);
            if ($hotel) {
                $selectedHotelDetails = [
                    'hotel' => $hotel,
                    'selected_room' => $selectedHotel['room_type'] ?? 'Tidak Spesifik'
                ];
            }
        }

        return view('konfirmasi', compact(
            'booking',
            'selectedTicket',
            'bookerDetails',
            'addOnPrices',
            'selectedMakananDetails',
            'selectedHotelDetails',
            'selectedSeats'
        ));
    }
}
