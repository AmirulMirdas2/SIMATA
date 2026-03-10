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

    public function laporanPoBus()
    {
        $poBuses = PoBus::with('user')->get();
        return view('admin.laporan_po', compact('poBuses'));
    }

    public function detailPendapatanPo($id, Request $request)
    {
        $poBus = PoBus::findOrFail($id);
        
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));

        // Sum total_harga
        $totalPendapatan = Pemesanan::where('status_bayar', 'Paid')
            ->whereDate('created_at', $tanggal)
            ->whereHas('jadwal.armada', function($query) use ($poBus) {
                // Ignore lint warnings
                $query->where('po_bus_id', $poBus->id);
            })->sum('total_harga');

        // Get details
        $pemesanans = Pemesanan::with(['user', 'jadwal.rute', 'jadwal.armada'])
            ->where('status_bayar', 'Paid')
            ->whereDate('created_at', $tanggal)
            ->whereHas('jadwal.armada', function($query) use ($poBus) {
                $query->where('po_bus_id', $poBus->id);
            })->latest()->get();

        return view('admin.detail_laporan_po', compact('poBus', 'tanggal', 'totalPendapatan', 'pemesanans'));
    }
}
