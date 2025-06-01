<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:flights,id',
            'contact_full_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
            'selected_makanan' => 'nullable|array',
            'selected_makanan.*' => 'exists:makanan,id',
            'selected_hotel' => 'nullable|array',
            'selected_hotel.id' => 'nullable|exists:hotel,id',
            'selected_hotel.room_type' => 'nullable|string'
        ], [
            'ticket_id.required' => 'ID tiket tidak ditemukan.',
            'ticket_id.exists' => 'Tiket yang Anda pilih tidak valid.',
            'contact_full_name.required' => 'Nama lengkap pemesan wajib diisi.',
            'contact_email.required' => 'Alamat email wajib diisi.',
            'contact_email.email' => 'Format alamat email tidak valid.',
            'contact_phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        $flight = Flight::findOrFail($validatedData['ticket_id']);

        $bookingCode = 'HKM' . Str::upper(Str::random(7));
        while (Booking::where('booking_code', $bookingCode)->exists()) {
            $bookingCode = 'HKM' . Str::upper(Str::random(7));
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'flight_id' => $flight->id,
            'booking_code' => $bookingCode,
            'passenger_full_name' => $validatedData['contact_full_name'],
            'passenger_email' => $validatedData['contact_email'],
            'passenger_phone' => $validatedData['contact_phone'],
            'selected_meals' => $validatedData['selected_meals'] ?? null,
            'selected_hotel' => $validatedData['selected_hotel'] ?? null,
            'total_price' => $flight->price_int,
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
     * @param  string  $booking_code
     * @return \Illuminate\Http\Response
     */
    public function confirmation($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->with('flight')->firstOrFail();

        $flight = $booking->flight;

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

        $selectedMakananDetails  = null;
        if ($booking->selected_makanan) {
            $selectedMakananDetails = Makanan::whereIn('id', $booking->selected_makanan)->get();
        }

        $selectedHotelDetails = null;
        if ($booking->selected_hotel && isset($booking->selected_hotel['id'])) {
            $hotel = Hotel::find($booking->selected_hotel['id']);
            if ($hotel) {
                $selectedHotelDetails = [
                    'hotel' => $hotel,
                    'selected_room' => $booking->selected_hotel['room_type']
                ];
            }
        }

        return view('konfirmasi', compact(
            'booking',
            'selectedTicket',
            'bookerDetails',
            'addOnPrices',
            'selectedMakananDetails',
            'selectedHotelDetails'
        ));
    }
}