<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'room_types'; // Pastikan nama tabel di database adalah 'room_types'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',          // Kunci asing ke tabel hotel
        'name_type',         // Nama tipe kamar (e.g., "Standard", "Deluxe")
        'deskripsi',         // Deskripsi tipe kamar
        'harga_per_malam',   // Harga per malam untuk tipe kamar ini
        'kapasitas',         // Kapasitas orang untuk tipe kamar ini
        'image',             // Gambar spesifik untuk tipe kamar ini
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga_per_malam' => 'decimal:2', // Mengatur 'harga_per_malam' sebagai decimal dengan 2 angka di belakang koma
        'kapasitas' => 'integer',         // Memastikan 'kapasitas' di-cast sebagai integer
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
     * Get the hotel that owns the room type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}