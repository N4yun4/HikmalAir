<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Jika kamu akan menggunakan Carbon untuk memformat tanggal di sini, jangan lupa import:
// use Carbon\Carbon;

class HotelController extends Controller
{
    // Method untuk menampilkan halaman daftar hotel
    public function index()
    {
        // DATA DUMMY
        $hotels = [
            [
                'id' => 1,
                'name' => 'Grand Hikmal Hotel',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'image' => 'images/grand-hotel-hikmal.jpeg',
                'rating' => 4.7,
                'description' => 'Hotel mewah bintang 5 di jantung kota dengan fasilitas lengkap dan pelayanan prima untuk perjalanan bisnis maupun liburan Anda.',
                'room_types' => [
                    ['name' => 'Standard Room', 'price_display' => '750.000', 'price_int' => 750000],
                    ['name' => 'Deluxe Room', 'price_display' => '1.100.000', 'price_int' => 1100000],
                    ['name' => 'Executive Suite', 'price_display' => '2.500.000', 'price_int' => 2500000],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Hikmal Resort',
                'location' => 'Seminyak, Bali',
                'image' => 'images/hikmal-resort.jpg',
                'rating' => 4.9,
                'description' => 'Nikmati suasana tropis yang menenangkan dengan pemandangan laut menakjubkan dan kolam renang pribadi yang eksklusif.',
                'room_types' => [
                    ['name' => 'Superior Pool View', 'price_display' => '1.200.000', 'price_int' => 1200000],
                    ['name' => 'Deluxe Ocean View', 'price_display' => '1.800.000', 'price_int' => 1800000],
                    ['name' => 'Private Villa with Pool', 'price_display' => '3.500.000', 'price_int' => 3500000],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Urban Hikmal',
                'location' => 'Malioboro, Yogyakarta',
                'image' => 'images/urban-hikmal.jpg',
                'rating' => 4.5,
                'description' => 'Akomodasi modern dan sangat nyaman, berlokasi strategis selangkah dari pusat budaya dan aneka kuliner.',
                'room_types' => [
                    ['name' => 'Cozy Standard', 'price_display' => '600.000', 'price_int' => 600000],
                    ['name' => 'Superior City View', 'price_display' => '850.000', 'price_int' => 850000],
                ]
            ],
            [
                'id' => 4,
                'name' => 'Hikmal Heights',
                'location' => 'Dago Pakar, Bandung',
                'image' => 'images/hikmal-heights.jpeg',
                'rating' => 4.6,
                'description' => 'Rasakan kesejukan Dago Pakar dengan pemandangan kota Bandung yang memukau dari ketinggian dan fasilitas rekreasi keluarga.',
                'room_types' => [
                    ['name' => 'Mountain View Room', 'price_display' => '900.000', 'price_int' => 900000],
                    ['name' => 'Family Suite (2 Bedroom)', 'price_display' => '1.500.000', 'price_int' => 1500000],
                ]
            ],
            [
                'id' => 5,
                'name' => 'Seaside Hikmal',
                'location' => 'Senggigi, Lombok',
                'image' => 'images/seaside-hikmal.jpeg',
                'rating' => 4.8,
                'description' => 'Resort eksotis di tepi pantai Senggigi yang tenang, lengkap dengan pasir putih lembut dan pemandangan air laut jernih.',
                'room_types' => [
                    ['name' => 'Beachfront Bungalow', 'price_display' => '1.700.000', 'price_int' => 1700000],
                    ['name' => 'Garden Villa Deluxe', 'price_display' => '1.300.000', 'price_int' => 1300000],
                ]
            ],
        ];

        // Mengirim data hotels ke view 'hotel.blade.php'
        return view('hotel', ['hotels' => $hotels]);
    }

    // Nanti kamu bisa tambahkan method lain di sini,
    // misalnya untuk menyimpan pilihan hotel ke session atau database, dll.
}
