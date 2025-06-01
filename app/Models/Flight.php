<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'airline_name',
        'departure_city',
        'departure_code',
        'arrival_city',
        'arrival_code',
        'departure_time',
        'arrival_time',
        'duration',
        'transit_info',
        'price_display',
        'price_int',
        'flight_class',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure_time' => 'datetime:H:i', // Cast sebagai waktu, format HH:MM
        'arrival_time' => 'datetime:H:i',   // Cast sebagai waktu, format HH:MM
        'date' => 'date',                  // Cast sebagai tanggal
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}