<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rute;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $rutes = Rute::all();
        $kotaAsals = $rutes->pluck('kota_asal')->unique();
        $kotaTujuans = $rutes->pluck('kota_tujuan')->unique();

        $jadwals = collect();

        if ($request->filled('kota_asal') && $request->filled('kota_tujuan') && $request->filled('tanggal')) {
            $jadwals = Jadwal::with(['armada.poBus', 'rute'])
                ->whereHas('rute', function ($query) use ($request) {
                    $query->where('kota_asal', $request->kota_asal)
                          ->where('kota_tujuan', $request->kota_tujuan);
                })
                ->whereDate('waktu_berangkat', $request->tanggal)
                ->where('waktu_berangkat', '>', now())
                ->get();
        }

        return view('penumpang.cari_jadwal', compact('kotaAsals', 'kotaTujuans', 'jadwals'));
    }

    public function pilihKursi($id)
    {
        $jadwal = Jadwal::with(['armada.kursis'])->findOrFail($id);

        $kursiTerkunci = Tiket::whereHas('pemesanan', function ($query) use ($jadwal) {
            $query->where('jadwal_id', $jadwal->id)
                  ->whereIn('status_bayar', ['Draft', 'Pending', 'Paid']);
        })->pluck('kursi_id')->toArray();

        return view('penumpang.pilih_kursi', compact('jadwal', 'kursiTerkunci'));
    }

    public function pesan(Request $request, $id)
    {
        $request->validate([
            'kursi' => 'required|array',
            'kursi.*' => 'exists:kursis,id',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        
        $kursiDipilih = $request->kursi;
        $kursiSudahDipesan = Tiket::whereIn('kursi_id', $kursiDipilih)
            ->whereHas('pemesanan', function ($query) use ($jadwal) {
                $query->where('jadwal_id', $jadwal->id)
                      ->whereIn('status_bayar', ['Draft', 'Pending', 'Paid']);
            })->exists();

        if ($kursiSudahDipesan) {
            return back()->with('error', 'Mohon maaf, beberapa kursi yang Anda pilih sudah dipesan orang lain barusan.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = $jadwal->harga_dasar * count($kursiDipilih);
            
            $pemesanan = Pemesanan::create([
                'user_id' => Auth::id(),
                'jadwal_id' => $jadwal->id,
                'batas_waktu_bayar' => Carbon::now()->addMinutes(30),
                'total_harga' => $totalHarga,
                'status_bayar' => 'Pending',
            ]);

            foreach ($kursiDipilih as $kursiId) {
                Tiket::create([
                    'pemesanan_id' => $pemesanan->id,
                    'kursi_id' => $kursiId,
                    'nama_penumpang' => Auth::user()->name,
                ]);
            }

            DB::commit();
            return redirect()->route('penumpang.pemesanan.detail', $pemesanan->id)
                ->with('success', 'Berhasil mengunci kursi. Silakan lakukan pembayaran sebelum waktu habis.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses pemesanan.');
        }
    }

    public function detailPemesanan($id)
    {
        $pemesanan = Pemesanan::with(['jadwal.rute', 'jadwal.armada.poBus', 'tikets.kursi'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('penumpang.detail_pemesanan', compact('pemesanan'));
    }

    public function bayar($id)
    {
        $pemesanan = Pemesanan::where('user_id', Auth::id())->where('status_bayar', 'Pending')->findOrFail($id);
        
        if (now() > $pemesanan->batas_waktu_bayar) {
            $pemesanan->update(['status_bayar' => 'Expired']);
            return back()->with('error', 'Waktu pembayaran telah habis.');
        }

        $pemesanan->update([
            'status_bayar' => 'Paid',
            'metode_pembayaran' => 'Virtual Account'
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
