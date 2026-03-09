<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoBus;
use App\Models\Rute;
use App\Models\Pemesanan;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPO = PoBus::count();
        $totalRute = Rute::count();
        $totalTransaksi = Pemesanan::where('status_bayar', 'Paid')->count();
        $totalPendapatan = Pemesanan::where('status_bayar', 'Paid')->sum('total_harga');

        return view('admin.dashboard', compact('totalPO', 'totalRute', 'totalTransaksi', 'totalPendapatan'));
    }
}
