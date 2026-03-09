<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rute extends Model
{
    use HasFactory;

    protected $fillable = [
        'kota_asal',
        'kota_tujuan'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
