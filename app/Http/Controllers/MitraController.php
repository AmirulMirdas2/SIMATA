<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\Tiket;

class MitraController extends Controller
{
    public function dashboard()
    {
        $poBus = Auth::user()->poBus;
        if (!$poBus) {
            return view('mitra.dashboard', ['error' => 'Anda belum memiliki integrasi PO Bus. Hubungi Administrasi.']);
        }

        $totalArmada = Armada::where('po_bus_id', $poBus->id)->count();
        $totalJadwal = Jadwal::whereIn('armada_id', Armada::where('po_bus_id', $poBus->id)->pluck('id'))->count();
        
        $jadwalIds = Jadwal::whereIn('armada_id', Armada::where('po_bus_id', $poBus->id)->pluck('id'))->pluck('id');
        $totalPemasukan = Pemesanan::whereIn('jadwal_id', $jadwalIds)->where('status_bayar', 'Paid')->sum('total_harga');

        return view('mitra.dashboard', compact('poBus', 'totalArmada', 'totalJadwal', 'totalPemasukan'));
    }

    public function manifest(Request $request)
    {
        $poBus = Auth::user()->poBus;
        if (!$poBus) {
            return redirect()->route('mitra.dashboard')->with('error', 'Akses terbatas.');
        }

        $jadwals = Jadwal::with(['rute', 'armada'])
            ->whereIn('armada_id', Armada::where('po_bus_id', $poBus->id)->pluck('id'))
            ->latest('waktu_berangkat')
            ->get();

        $selectedJadwal = null;
        $kursis = collect();
        $tiketsMapped = [];

        if ($request->has('jadwal_id')) {
            $selectedJadwal = Jadwal::with('armada.kursis')->findOrFail($request->jadwal_id);
            // Ensure this jadwal belongs to this mitra
            if ($selectedJadwal->armada->po_bus_id !== $poBus->id) {
                abort(403, 'Unauthorized access to this jadwal.');
            }

            $kursis = $selectedJadwal->armada->kursis;

            $tikets = Tiket::with(['kursi', 'pemesanan.user'])
                ->whereHas('pemesanan', function ($query) use ($selectedJadwal) {
                    $query->where('jadwal_id', $selectedJadwal->id)
                          ->where('status_bayar', 'Paid');
                })->get();
            
            foreach ($tikets as $tiket) {
                $tiketsMapped[$tiket->kursi_id] = $tiket;
            }
        }

        return view('mitra.manifest', compact('jadwals', 'selectedJadwal', 'kursis', 'tiketsMapped'));
    }
}
