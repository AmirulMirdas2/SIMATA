<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function mitra()
    {
        return view('mitra.dashboard');
    }

    public function penumpang()
    {
        $riwayatPemesanan = \App\Models\Pemesanan::with(['jadwal.rute', 'jadwal.armada.poBus'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('penumpang.dashboard', compact('riwayatPemesanan'));
    }
}
