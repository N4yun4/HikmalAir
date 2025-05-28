<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Jangan lupa import Carbon

class PilihTiketController extends Controller
{
    // Fungsi untuk menyediakan data dummy tiket
    private function getDummyTicketsData() {
        return [
            [
                'id' => 1,
                'airline_name' => 'HikmalAir',
                'departure_city' => 'Surabaya',
                'departure_code' => 'SUB',
                'arrival_city' => 'Jakarta',
                'arrival_code' => 'CGK',
                'departure_time' => '07:00',
                'arrival_time' => '08:30',
                'duration' => '1j 30m',
                'transit_info' => 'Langsung',
                'price_display' => '750.000',
                'price_int' => 750000,
                'flight_class' => 'Ekonomi',
                'date' => '2025-07-20'
            ],
            [
                'id' => 2,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-202',
                'departure_city' => 'Surabaya',
                'departure_code' => 'SUB',
                'arrival_city' => 'Jakarta',
                'arrival_code' => 'CGK',
                'departure_time' => '12:30',
                'arrival_time' => '13:55',
                'duration' => '1j 25m',
                'transit_info' => 'Langsung',
                'price_display' => '800.000',
                'price_int' => 800000,
                'flight_class' => 'Ekonomi',
                'date' => '2025-07-20'
            ],
            [
                'id' => 3,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-303',
                'departure_city' => 'Surabaya',
                'departure_code' => 'SUB',
                'arrival_city' => 'Jakarta',
                'arrival_code' => 'CGK',
                'departure_time' => '19:00',
                'arrival_time' => '20:30',
                'duration' => '1j 30m',
                'transit_info' => 'Langsung',
                'price_display' => '1.200.000',
                'price_int' => 1200000,
                'flight_class' => 'Bisnis',
                'date' => '2025-07-20'
            ],
            [
                'id' => 4,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-007',
                'departure_city' => 'Jakarta',
                'departure_code' => 'CGK',
                'arrival_city' => 'Surabaya',
                'arrival_code' => 'SUB',
                'departure_time' => '08:15',
                'arrival_time' => '09:45',
                'duration' => '1j 30m',
                'transit_info' => 'Langsung',
                'price_display' => '650.000',
                'price_int' => 650000,
                'flight_class' => 'Ekonomi',
                'date' => '2025-07-21'
            ],
            [
                'id' => 5,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-105',
                'departure_city' => 'Surabaya',
                'departure_code' => 'SUB',
                'arrival_city' => 'Denpasar',
                'arrival_code' => 'DPS',
                'departure_time' => '14:30',
                'arrival_time' => '16:25',
                'duration' => '0j 55m',
                'transit_info' => 'Langsung',
                'price_display' => '920.000',
                'price_int' => 920000,
                'flight_class' => 'Ekonomi',
                'date' => '2025-07-22'
            ],
            [
                'id' => 6,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-305',
                'departure_city' => 'Jakarta',
                'departure_code' => 'CGK',
                'arrival_city' => 'Medan',
                'arrival_code' => 'KNO',
                'departure_time' => '20:00',
                'arrival_time' => '22:10',
                'duration' => '2j 10m',
                'transit_info' => 'Langsung',
                'price_display' => '1.100.000',
                'price_int' => 1100000,
                'flight_class' => 'Ekonomi',
                'date' => '2025-07-21'
            ],
        ];
    }

    public function index(Request $request)
    {
        $dari = strtoupper($request->input('dari'));
        $ke = strtoupper($request->input('ke'));
        $tanggalBerangkat = $request->input('tanggal_berangkat');

        $allTickets = $this->getDummyTicketsData();
        $foundTickets = [];

        if (empty($dari) && empty($ke) && empty($tanggalBerangkat)) {
            $foundTickets = $allTickets;
        } else {
            foreach ($allTickets as $ticket) {
                $matchDari = !$dari || $ticket['departure_code'] === $dari;
                $matchKe = !$ke || $ticket['arrival_code'] === $ke;
                $matchTanggal = !$tanggalBerangkat || $ticket['date'] === $tanggalBerangkat;

                if ($matchDari && $matchKe && $matchTanggal) {
                    $foundTickets[] = $ticket;
                }
            }
        }

        return view('pilihtiket', [
            'tickets' => $foundTickets,
            'searchParams' => $request->all()
        ]);
    }

    public function showDeskripsi($id)
    {
        $ticket = null;
        foreach ($this->getDummyTicketsData() as $t) {
            if ($t['id'] == $id) {
                $ticket = $t;
                $ticket['formatted_date'] = Carbon::parse($ticket['date'])->translatedFormat('D, d M Y');
                break;
            }
        }

        if (!$ticket) {
            abort(404, 'Detail tiket yang Anda cari tidak ditemukan.');
        }

        return view('deskripsitiket', [
            'ticket' => $ticket
        ]);
    }
}
