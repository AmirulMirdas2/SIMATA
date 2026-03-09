<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'armada_id',
        'rute_id',
        'waktu_berangkat',
        'harga_dasar'
    ];

    protected function casts(): array
    {
        return [
            'waktu_berangkat' => 'datetime',
            'harga_dasar' => 'decimal:2',
        ];
    }

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }
}
