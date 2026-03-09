<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'waktu_pesan',
        'batas_waktu_bayar',
        'total_harga',
        'status_bayar',
        'metode_pembayaran'
    ];

    protected function casts(): array
    {
        return [
            'waktu_pesan' => 'datetime',
            'batas_waktu_bayar' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
