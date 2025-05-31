<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Carbon\Carbon;

// class KonfirmasiController extends Controller
// {
//     public function index(Request $request)
//     {
//         $selectedTicket = [
//             'id' => 1, 'airline_name' => 'HikmalAir', 'flight_number' => 'HA-001',
//             'departure_code' => 'SUB', 'departure_city' => 'Surabaya', 'departure_terminal' => 'T1 Domestik',
//             'arrival_code' => 'CGK', 'arrival_city' => 'Jakarta', 'arrival_terminal' => 'T3 Domestik',
//             'departure_time' => '07:00', 'arrival_time' => '08:30', 'duration' => '1j 30m',
//             'transit_info' => 'Langsung', 'price_display' => '750.000', 'price_int' => 750000,
//             'flight_class' => 'Ekonomi', 'date' => '2025-08-15',
//             'formatted_date' => Carbon::parse('2025-08-15')->translatedFormat('D, d M Y'),
//         ];
//         $bookerDetails = [
//             'contact_full_name' => 'fullan',
//             'contact_email' => 'fullan@anjay.com',
//             'contact_phone' => '08888888888',
//         ];

//         // Harga dan data dummy untuk add-ons
//         $addOnPrices = [
//             'insurance' => 55000,
//             'baggage' => ['10kg' => 120000, '20kg' => 220000, '30kg' => 300000, '40kg' => 380000],
//             'pickup' => ['motor' => 60000, 'mobil_kecil' => 130000, 'mobil_besar' => 200000],
//             'meals' => [ // Data dummy makanan
//                 ['name' => 'Nasi Goreng Spesial', 'price_int' => 45000, 'price_display' => number_format(45000, 0, ',', '.')],
//                 ['name' => 'Susu Kotak UHT', 'price_int' => 15000, 'price_display' => number_format(15000, 0, ',', '.')],
//                 ['name' => 'Air Mineral Botol', 'price_int' => 10000, 'price_display' => number_format(10000, 0, ',', '.')]
//             ]
//         ];

//         $selectedHotelDetails = null;
//         // $selectedHotelDetails = [
//         //     'name' => 'Grand Hikmal Hotel Jakarta',
//         //     'room_type' => 'Deluxe Room',
//         //     'check_in' => '2025-08-15',
//         //     'check_out' => '2025-08-17',
//         //     'duration' => 2,
//         //     'price_int' => 2200000,
//         //     'price_display' => number_format(2200000, 0, ',', '.')
//         // ];

//         $selectedMealsDetails = null;
//         // $selectedMealsDetails = [
//         //     'items' => ['Nasi Goreng Spesial'], // Nama makanan yang dipilih
//         //     'price_int' => 45000, // Total harga makanan yang dipilih
//         //     'price_display' => number_format(45000, 0, ',', '.')
//         // ];

//         return view('konfirmasi', compact(
//             'selectedTicket',
//             'bookerDetails',
//             'addOnPrices',
//             'selectedHotelDetails',
//             'selectedMealsDetails'
//         ));
//     }
// }
