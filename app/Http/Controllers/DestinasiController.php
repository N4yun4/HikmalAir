<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    public function Destinasi()
{
    $destinasi = [
        [
            'nama' => 'Bali',
            'gambar' => '/images/bali.jpg',
            'deskripsi' => 'Bali, pulau dewata yang mempesona, menyajikan harmoni sempurna antara alam tropis yang hijau, budaya spiritual yang mendalam, dan seni yang hidup. Setiap sudutnya mengundang jiwa untuk menemukan kedamaian dan keindahan tanpa batas.',
            'rating' => 4.8
        ],
        [
            'nama' => 'Yogyakarta',
            'gambar' => '/images/jogja.jpg',
            'deskripsi' => 'Yogyakarta, kota pelajar dan seni, merupakan jantung budaya Jawa yang sarat dengan sejarah. Dari keraton yang agung hingga kerajinan tangan yang memukau, setiap langkah menghidupkan kisah masa lalu dan semangat masa kini.',
            'rating' => 4.6
        ],
        [
            'nama' => 'Bandung',
            'gambar' => '/images/bandung.jpg',
            'deskripsi' => 'Bandung, kota kembang yang sejuk, menawarkan perpaduan unik antara lanskap pegunungan yang menenangkan dan dinamika urban yang modern. Suasana kreatif dan kuliner khas membuatnya menjadi destinasi penuh inspirasi.',
            'rating' => 4.5
        ],
        [
            'nama' => 'Surabaya',
            'gambar' => '/images/surabaya.jpg',
            'deskripsi' => 'Surabaya, kota pahlawan yang penuh semangat, memancarkan energi urban yang kuat dengan sejarah perjuangan yang membara. Kota ini menampilkan harmoni antara kemajuan industri dan kekayaan budaya tradisional Jawa Timur.',
            'rating' => 4.3
        ],
        [
            'nama' => 'Jakarta',
            'gambar' => '/images/jakarta.jpeg',
            'deskripsi' => 'Jakarta, ibu kota yang dinamis, adalah pusat kegiatan dan keberagaman. Kota metropolitan ini memadukan modernitas dengan budaya lokal, menjadi cermin kehidupan urban yang cepat namun penuh warna dan peluang.',
            'rating' => 4.2
        ],
    ];

    return view('destinasi', compact('destinasi'));
    }
}