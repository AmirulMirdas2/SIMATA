<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Jadwal;
use App\Models\Rute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraJadwalController extends Controller
{
    public function index()
    {
        $poBus = Auth::user()->poBus;
        $armadaIds = Armada::where('po_bus_id', $poBus->id)->pluck('id');
        
        $jadwals = Jadwal::with(['rute', 'armada'])
            ->whereIn('armada_id', $armadaIds)
            ->latest('waktu_berangkat')
            ->get();
            
        return view('mitra.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $poBus = Auth::user()->poBus;
        $armadas = Armada::where('po_bus_id', $poBus->id)->get();
        $rutes = Rute::all();
        
        return view('mitra.jadwal.create', compact('armadas', 'rutes'));
    }

    public function store(Request $request)
    {
        $poBus = Auth::user()->poBus;

        $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'rute_id' => 'required|exists:rutes,id',
            'waktu_berangkat' => 'required|date|after:now',
            'harga_dasar' => 'required|numeric|min:1000',
        ]);

        // Security Check: Make sure the chosen armada belongs to the current user's PO Bus
        $armada = Armada::findOrFail($request->armada_id);
        if ($armada->po_bus_id !== $poBus->id) {
            abort(403, 'Armada tidak sah.');
        }

        Jadwal::create($request->all());

        return redirect()->route('mitra.jadwal.index')->with('success', 'Jadwal baru berhasil dibuat.');
    }

    public function edit(Jadwal $jadwal)
    {
        $this->authorizeOwner($jadwal);
        
        $poBus = Auth::user()->poBus;
        $armadas = Armada::where('po_bus_id', $poBus->id)->get();
        $rutes = Rute::all();

        return view('mitra.jadwal.edit', compact('jadwal', 'armadas', 'rutes'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $this->authorizeOwner($jadwal);

        $request->validate([
            'armada_id' => 'required|exists:armadas,id',
            'rute_id' => 'required|exists:rutes,id',
            'waktu_berangkat' => 'required|date',
            'harga_dasar' => 'required|numeric|min:1000',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('mitra.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $this->authorizeOwner($jadwal);
        $jadwal->delete();
        return redirect()->route('mitra.jadwal.index')->with('success', 'Jadwal dihapus.');
    }

    private function authorizeOwner(Jadwal $jadwal)
    {
        $poBus = Auth::user()->poBus;
        if ($jadwal->armada->po_bus_id !== $poBus->id) {
            abort(403, 'Akses tidak sah.');
        }
    }
}
