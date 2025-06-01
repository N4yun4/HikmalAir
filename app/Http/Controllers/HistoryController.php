<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $daftarPemesanan = [
            [
                'id_pemesanan' => 'HA-INV-00123',
                'tipe_pesanan' => 'Tiket Pesawat',
                'detail_utama' => 'HikmalAir (HA-101) | Surabaya (SUB) → Jakarta (CGK)',
                'tanggal_pemesanan' => '20 Mei 2025',
                'tanggal_perjalanan_atau_checkin' => '15 Agustus 2025',
                'status' => 'aktif',
                'total_harga_display' => '750.000',
                'link_detail' => '#',
                'sudah_rating' => false,
                'rating_value' => null
            ],
            [
                'id_pemesanan' => 'HA-INV-00098',
                'tipe_pesanan' => 'Tiket Pesawat',
                'detail_utama' => 'HikmalAir (HA-202) | Jakarta (CGK) → Denpasar (DPS)',
                'tanggal_pemesanan' => '10 April 2025',
                'tanggal_perjalanan_atau_checkin' => '01 Juni 2025',
                'status' => 'Selesai',
                'total_harga_display' => '680.000',
                'link_detail' => '#',
                'sudah_rating' => true,
                'rating_value' => 4
            ],
            [
                'id_pemesanan' => 'HA-INV-00085',
                'tipe_pesanan' => 'Tiket Pesawat',
                'detail_utama' => 'HikmalAir (HA-305) | Medan (KNO) → Yogyakarta (YIA)',
                'tanggal_pemesanan' => '01 Maret 2025',
                'tanggal_perjalanan_atau_checkin' => '20 April 2025',
                'status' => 'Selesai',
                'total_harga_display' => '1.150.000',
                'link_detail' => '#',
                'sudah_rating' => false,
                'rating_value' => null
            ],
        ];
        return view('history', ['daftarPemesanan' => $daftarPemesanan]);
    }
}
