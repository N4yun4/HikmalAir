<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Makanan;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Memproses data dari form deskripsi tiket dan redirect ke halaman pemilihan kursi
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function processBooking(Request $request)
    {
        // Validasi data dari form deskripsi tiket
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id',
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

        // Ambil data makanan dan hotel dari session
        $selectedMakanan = session('selected_makanan', []);
        $selectedHotel = session('selected_hotel', []);

        // Redirect ke halaman pemilihan kursi dengan data yang sudah divalidasi
        return redirect()->route('seat.selection', [
            'ticket_id' => $validatedData['ticket_id'],
            'contact_full_name' => $validatedData['contact_full_name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
            'selected_makanan' => json_encode($selectedMakanan),
            'selected_hotel' => json_encode($selectedHotel),
        ]);
    }

    /**
     * Menampilkan halaman pemilihan kursi.
     * Menerima data dari form deskripsi tiket (GET request).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showSeatSelection(Request $request): View
    {
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id',
            'contact_full_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
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

        $selectedMakananJson = $validatedData['selected_makanan'] ?? '[]';
        $selectedHotelJson = $validatedData['selected_hotel'] ?? '[]';

        return view('seat', [
            'ticket' => $flight,
            'contact_full_name' => $validatedData['contact_full_name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
            'selected_makanan' => $selectedMakananJson,
            'selected_hotel' => $selectedHotelJson,
        ]);
    }

    /**
     * Memproses pemesanan akhir setelah pemilihan kursi.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function finalizeBooking(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id',
            'contact_full_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
            'selected_seats' => 'required|json',
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
            'seat' => $selectedSeats,
            'selected_meals' => $selectedMakanan,
            'selected_hotel' => $selectedHotel,
            'total_price' => $totalPrice,
            'booking_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => null,
            'booked_at' => now(),
        ]);

        // Hapus data dari session setelah booking berhasil
        session()->forget(['selected_makanan', 'selected_hotel']);

        return redirect()->route('booking.confirmation', ['booking_code' => $booking->booking_code])
                        ->with('success', 'Pemesanan Anda berhasil dibuat!');
    }

    /**
     * Menampilkan halaman konfirmasi pemesanan.
     *
     * @param string $booking_code
     * @return \Illuminate\Http\Response
     */
    // public function confirmation($booking_code): View
    // {
    //     $booking = Booking::where('booking_code', $booking_code)->with('flight')->firstOrFail();

    //     $flight = $booking->flight;

    //     $selectedSeats = $booking->seat;

    //     $selectedMeals = $booking->selected_meals;

    //     $selectedMealsDetails = null;
    //     if (!empty($selectedMeals) && is_array($selectedMeals)) {
    //         $selectedMealsDetails = Makanan::whereIn('id', $selectedMeals)->get();
    //     }

    //     $selectedHotel = $booking->selected_hotel;

    //     $selectedTicket = [
    //         'airline_name' => $flight->airline_name,
    //         'flight_number' => 'HA-' . $flight->id,
    //         'flight_class' => $flight->flight_class,
    //         'departure_city' => $flight->departure_city,
    //         'departure_code' => $flight->departure_code,
    //         'arrival_city' => $flight->arrival_city,
    //         'arrival_code' => $flight->arrival_code,
    //         'formatted_date' => $flight->date->translatedFormat('D, d M Y'),
    //         'departure_time' => $flight->departure_time,
    //         'arrival_time' => $flight->arrival_time,
    //         'duration' => $flight->duration,
    //         'price_display' => $flight->price_display,
    //         'price_int' => $flight->price_int,
    //     ];

    //     $bookerDetails = [
    //         'contact_full_name' => $booking->passenger_full_name,
    //         'contact_email' => $booking->passenger_email,
    //         'contact_phone' => $booking->passenger_phone,
    //     ];

    //     $addOnPrices = [
    //         'insurance' => 55000,
    //         'baggage' => [
    //             '10kg' => 120000, '20kg' => 220000, '30kg' => 300000, '40kg' => 380000
    //         ],
    //         'pickup' => [
    //             'motor' => 60000, 'mobil_kecil' => 130000, 'mobil_besar' => 200000
    //         ]
    //     ];

    //     $selectedMealsDetails = null;
    //     if (!empty($selectedMeals) && is_array($selectedMeals)) {
    //         $selectedMealsDetails = Makanan::whereIn('id', $selectedMeals)->get();
    //     }

    //     $selectedHotelDetails = null;
    //     if (!empty($selectedHotel) && is_array($selectedHotel) && isset($selectedHotel['id'])) {
    //         $hotel = Hotel::find($selectedHotel['id']);
    //         if ($hotel) {
    //             $selectedHotelDetails = [
    //                 'hotel' => $hotel,
    //                 'selected_room' => $selectedHotel['room_type'] ?? 'Tidak Spesifik'
    //             ];
    //         }
    //     }

    //     return view('konfirmasi', compact(
    //         'booking',
    //         'selectedTicket',
    //         'bookerDetails',
    //         'addOnPrices',
    //         'selectedMealsDetails',
    //         'selectedHotelDetails',
    //         'selectedSeats'
    //     ));
    // }

    public function confirmation($booking_code): View
    {
        $booking = Booking::where('booking_code', $booking_code)->with('flight')->firstOrFail();

        $flight = $booking->flight;
        $selectedSeats = $booking->seat;

        // Ambil selected_meals dari booking
        $selectedMeals = $booking->selected_meals;

        // Hitung total harga makanan
        $totalMakanan = 0;
        $selectedMealsDetails = null;

        if (!empty($selectedMeals) && is_array($selectedMeals)) {
            $selectedMealsDetails = Makanan::whereIn('id', $selectedMeals)->get();

            // Hitung total harga makanan
            foreach ($selectedMealsDetails as $makanan) {
                $totalMakanan += $makanan->price;
            }
        }

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
            'price_int' => $flight->price_int, // Pastikan ini ada
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

        $selectedHotelDetails = null;
        if (!empty($selectedHotel) && is_array($selectedHotel) && isset($selectedHotel['id'])) {
            $hotel = Hotel::find($selectedHotel['id']);
            if ($hotel) {
                $selectedHotelDetails = [
                    'hotel' => $hotel,
                    'selected_room' => $selectedHotel['room_type'] ?? 'Tidak Spesifik'
                ];
            }
        }

        // Hitung total pembayaran
        $totalPembayaran = $selectedTicket['price_int'] + $totalMakanan;

        return view('konfirmasi', compact(
            'booking',
            'selectedTicket',
            'bookerDetails',
            'addOnPrices',
            'selectedMealsDetails',
            'selectedHotelDetails',
            'selectedSeats',
            'totalMakanan',
            'totalPembayaran' // Kirim total pembayaran ke view
        ));
    }

    public function simpanSementara(Request $request)
    {
        $request->validate([
            'selectedMeals' => 'required|array',
            'selectedMeals.*' => 'integer|min:1',
            'booking_code' => 'required|exists:bookings,booking_code'
        ]);

        $booking = Booking::where('booking_code', $request->booking_code)->first();

        if ($booking) {
            $booking->selected_meals = $request->selectedMeals;
            $booking->save();

            return redirect()->route('booking.confirmation', ['booking_code' => $booking->booking_code])
                            ->with('success', 'Makanan berhasil ditambahkan!');
        }

        return back()->with('error', 'Booking tidak ditemukan!');
    }

    public function hapusMakanan($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan!');
        }

        // Set selected_meals menjadi array kosong
        $booking->selected_meals = [];
        $booking->save();

        return redirect()->route('booking.confirmation', ['booking_code' => $booking->booking_code])
                        ->with('success', 'Pesanan makanan berhasil dihapus!');
    }
}
