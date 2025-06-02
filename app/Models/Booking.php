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
        'seat',
        'total_price',
        'booking_status',
        'payment_status',
        'payment_method',
        'booked_at',
        'selected_makanan',
        'selected_hotel',
        'selected_meals'
    ];

    protected $casts = [
        'seat' => 'array',
        'booked_at' => 'datetime',
        'total_price' => 'decimal:2',
        'selected_makanan' => 'array',
        'selected_hotel' => 'array',
        'selected_meals' => 'array'
    ];

    public function meals()
    {
        return $this->belongsToMany(Makanan::class, 'booking_makanan', 'booking_id', 'makanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
