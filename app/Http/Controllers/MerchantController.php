<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = [
            [
                'id' => 1,
                'name' => 'Captain Hikmal',
                'rating' => 4.5,
                'description' => 'Minifigure Captain Hikmal berbahan plastik berukuran 2x1,5 cm.. dapat digerakkan dan dipose, hadir dengan wajah terkejut khas Captain Hikmal',
                'image' => 'images/captainHikmal.jpg',
                'price' => 75000
            ],
            [
                'id' => 2,
                'name' => 'HikmalAir - Beach Shirt',
                'rating' => 4.7,
                'description' => 'Kemeja pantai dengan design unik, menonjolkan karakteristik dengan masih mempertahankan kekayaan batik indonesia',
                'image' => 'images/beachShirt.jpg',
                'price' => 100000
            ],
            [
                'id' => 3,
                'name' => 'HikmalAir - Black Mug',
                'rating' => 4.5,
                'description' => 'Mug keramik berwarna Hitam, dengan tekstur mate yang memberikan kesan elegan. Cocok untuk menjadi kenang-kenangan terbang bersama HikmalAir',
                'image' => 'images/gelas.jpg',
                'price' => 60000
            ],
            [
                'id' => 4,
                'name' => 'HikmalAir - BlackPen',
                'rating' => 4.5,
                'description' => 'Bolpoin hitam elegan, dengan tinta gel. Dapat digunakan menulis indah dan kenang-kenangan terbang bersama HikmalAir',
                'image' => 'images/pulpen.jpg',
                'price' => 25000
            ],
            [
                'id' => 5,
                'name' => 'HikmalAir - Sandals',
                'rating' => 4.5,
                'description' => 'Sandal lembut dengan bantalan empuk, cocok untuk menemani waktu istirahatmu setelah penerbangan dan perjalan yang panjang. Nyaman seperti terbang bersama HikmalAir',
                'image' => 'images/sandal.jpg',
                'price' => 120000
            ],
            [
                'id' => 6,
                'name' => 'HikmalAir - MiniTowel',
                'rating' => 4.5,
                'description' => 'Handuk kecil yang cocok untuk dibawa liburan, berbahan lembut dan tidak membuat kulit iritasi, nyaman dan menenangkan seperti terbang bersama HikmalAir',
                'image' => 'images/handuk.jpg',
                'price' => 40000
            ],
            [
                'id' => 7,
                'name' => 'Captain Hikmal Seasonal Poster',
                'rating' => 4.5,
                'description' => 'Poster Maskot HikmalAir edisi pertama, menampilkan boneka Captain Hikmal yang siap terbang bersamamu',
                'image' => 'images/captainHikmalPoster.jpg',
                'price' => 35000
            ],
        ];

        return view('merchant', compact('merchants'));
    }
}
