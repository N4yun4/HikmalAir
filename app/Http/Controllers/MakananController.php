<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index()
    {
        // DATA DUMMY
        $daftarMakanan = [
            [
                'id' => 'MK001',
                'name' => 'Salad Sayuran Segar',
                'deskripsi' => 'Perpaduan segar dari aneka sayuran hijau pilihan, daun selada yang renyah, tomat ceri, paprika merah, dan potongan mentimun segar yang disajikan dengan saus vinaigrette lemon yang ringan dan menyegarkan.',
                'image' => 'images/salad.jpg',
                'price' => '35000',
                'price_display' => 35000,
            ],
            [
                'id' => 'MK002',
                'name' => 'Nasi Goreng Spesial HikmalAir',
                'deskripsi' => 'Nasi goreng harum yang dimasak dengan bumbu spesial racikan HikmalAir, dipadu dengan potongan ayam, udang, sayuran segar, telur mata sapi, dan kerupuk. Cita rasa gurih dan teksturnya yang lembut menghadirkan pengalaman kuliner yang mengenyangkan.',
                'image' => 'images/nasgor.jpg',
                'price' => '55000',
                'price_display' => 55000,
            ],
            [
                'id' => 'MK003',
                'name' => 'Air Mineral Kemasan',
                'deskripsi' => 'Air mineral murni dari sumber pegunungan pilihan, dikemas dalam botol untuk menjaga hidrasi tubuh Anda selama perjalanan. Dingin dan menyegarkan, memberikan kesegaran instan.',
                'image' => 'images/mineral.jpg',
                'price' => '10000',
                'price_display' => 10000,
            ],
            [
                'id' => 'MK004',
                'name' => 'Kopi Latte Premium',
                'deskripsi' => 'Racikan biji kopi arabika pilihan yang menghasilkan espresso lembut dan kuat, dipadukan dengan susu steam berkualitas. Dihidangkan hangat dengan aroma khas yang menenangkan, latte ini adalah teman sempurna untuk momen relaksasi Anda di udara.',
                'image' => 'images/coffee.jpg',
                'price' => '25000',
                'price_display' => 25000,
            ],
        ];

        return view('makanan', ['daftarMakanan' => $daftarMakanan]);
    }
}
