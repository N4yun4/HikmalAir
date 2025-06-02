<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'makanan'; // Pastikan nama tabel di database adalah 'makanan'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',          // Sesuai dengan kolom 'name' di tabel
        'deskripsi',     // Sesuai dengan kolom 'deskripsi' di tabel
        'image',         // Sesuai dengan kolom 'image' di tabel
        'price',         // Sesuai dengan kolom 'price' di tabel
        'price_display', // Sesuai dengan kolom 'price_display' di tabel
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2', // Mengatur 'price' sebagai decimal dengan 2 angka di belakang koma
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
}