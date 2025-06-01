<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $promoTickets = [
            [
                'id' => 101,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-001',
                'departure_code' => 'SUB',
                'arrival_code' => 'CGK',
                'departure_time' => '06:00',
                'arrival_time' => '07:20',
                'duration' => '1j 20m',
                'transit_info' => 'Langsung',
                'price_display' => '450.000',
                'flight_class' => 'Ekonomi'
            ],
            [
                'id' => 102,
                'airline_name' =>'HikmalAir',
                'flight_number' => 'HA-002',
                'departure_code' => 'CGK',
                'arrival_code' => 'DPS',
                'departure_time' => '10:30',
                'arrival_time' => '12:05',
                'duration' => '1j 35m',
                'transit_info' => 'Langsung',
                'price_display' => '485.000',
                'flight_class' => 'Ekonomi'
            ],
            [
                'id' => 103,
                'airline_name' => 'HikmalAir',
                'flight_number' => 'HA-003',
                'departure_code' => 'BDO',
                'arrival_code' => 'SUB',
                'departure_time' => '15:00',
                'arrival_time' => '16:10',
                'duration' => '1j 10m',
                'transit_info' => 'Langsung',
                'price_display' => '420.000',
                'flight_class' => 'Ekonomi'
            ],
            [
                'id' => 104,
                'airline_name' =>'HikmalAir',
                'flight_number' => 'HE-003',
                'departure_code' => 'KNO',
                'arrival_code' => 'CGK',
                'departure_time' => '18:05',
                'arrival_time' => '20:05',
                'duration' => '2j 00m',
                'transit_info' => 'Langsung',
                'price_display' => '510.000',
                'flight_class' => 'Ekonomi'
            ],
        ];

        $popularDestinations = [
            [
                'name' => 'Yogyakarta',
                'image' => 'images/jogja.jpg',
                'tagline' => 'Jelajahi budaya Jawa yang kaya, candi-candi kuno, dan nikmati suasana kota yang hangat.',
                'rating' => 4.8,
                'link' => '/destinasi'
            ],
            [
                'name' => 'Bali',
                'image' => 'images/bali.jpg',
                'tagline' => 'Nikmati keindahan pantai, sawah hijau, upacara adat, dan keramahan penduduk Bali.',
                'rating' => 4.9,
                'link' => '/destinasi'
            ],
            [
                'name' => 'Bandung',
                'image' => 'images/bandung.jpg',
                'tagline' => 'Rasakan sejuknya udara pegunungan, nikmati kuliner kreatif, dan jelajahi factory outlet.',
                'rating' => 4.6,
                'link' => '/destinasi'
            ],
            [
                'name' => 'Surabaya',
                'image' => 'images/surabaya.jpg',
                'tagline' => 'Kota Pahlawan dengan sejarah yang kaya, kuliner yang beragam, dan pusat bisnis yang dinamis.',
                'rating' => 4.7,
                'link' => '/destinasi'
            ],
        ];

        return view('dashboard', compact('promoTickets', 'popularDestinations'));
    }
}
