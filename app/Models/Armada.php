<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Armada extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_bus_id',
        'plat_nomor',
        'kelas',
        'fasilitas',
        'total_kursi'
    ];

    public function poBus()
    {
        return $this->belongsTo(PoBus::class);
    }

    public function kursis()
    {
        return $this->hasMany(Kursi::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
