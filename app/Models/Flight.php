<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights'; 

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

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',  
        'date' => 'date',                  
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}