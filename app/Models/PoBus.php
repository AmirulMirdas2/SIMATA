<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoBus extends Model
{
    use HasFactory;

    protected $table = 'po_bus';

    protected $fillable = [
        'user_id',
        'nama_po',
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function armadas()
    {
        return $this->hasMany(Armada::class);
    }
}
