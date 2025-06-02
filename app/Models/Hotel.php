<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotel'; // Pastikan nama tabel di database adalah 'hotel'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // Sesuai dengan kolom 'name' di tabel
        'location',    // Sesuai dengan kolom 'location' di tabel
        'image',       // Sesuai dengan kolom 'image' di tabel
        'rating',      // Sesuai dengan kolom 'rating' di tabel
        'descrption',  // Sesuai dengan kolom 'descrption' di tabel
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'decimal:1', // Mengatur 'rating' sebagai decimal dengan 1 angka di belakang koma
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Define the relationship with RoomType.
     * A hotel can have many room types.
     */
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
}