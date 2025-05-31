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
        'total_price',
        'booking_status',
        'payment_status',
        'payment_method',
        'booked_at',
    ];

    protected $casts = [
        'booked_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    // --- Relasi yang sudah Anda buat untuk user (jika ada) ---
    public function user()
    {
        return $this->belongsTo(User::class); // Pastikan model User ada
    }

    // --- Tambahkan relasi ini ---
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
    // ---------------------------
}