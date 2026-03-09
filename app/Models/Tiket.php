<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tiket extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'pemesanan_id',
        'kursi_id',
        'nama_penumpang',
        'nik_penumpang',
        'qr_code',
        'status_checkin'
    ];

    protected function casts(): array
    {
        return [
            'status_checkin' => 'boolean',
        ];
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function kursi()
    {
        return $this->belongsTo(Kursi::class);
    }
}
