<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_code',
        'passenger_full_name',
        'passenger_email',
        'passenger_phone',
        'seat', // <--- TAMBAHKAN INI
        'total_price',
        'booking_status',
        'payment_status',
        'payment_method',
        'booked_at',
        'selected_makanan',
        'selected_hotel'
    ];

    protected $casts = [
        'seat' => 'array', // <--- TAMBAHKAN INI
        'booked_at' => 'datetime',
        'total_price' => 'decimal:2', // Pastikan kolom di DB juga DECIMAL atau FLOAT
        'selected_makanan' => 'array',
        'selected_hotel' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
