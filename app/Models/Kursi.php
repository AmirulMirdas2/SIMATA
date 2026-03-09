<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kursi extends Model
{
    use HasFactory;

    protected $fillable = [
        'armada_id',
        'nomor_kursi'
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
