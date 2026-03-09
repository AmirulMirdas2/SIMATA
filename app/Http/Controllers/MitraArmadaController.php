<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Kursi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraArmadaController extends Controller
{
    public function index()
    {
        $poBus = Auth::user()->poBus;
        if (!$poBus) {
            return redirect()->route('mitra.dashboard')->with('error', 'Akses dibatasi. Anda belum memiliki PO.');
        }

        $armadas = Armada::where('po_bus_id', $poBus->id)->latest()->get();
        return view('mitra.armada.index', compact('armadas'));
    }

    public function create()
    {
        return view('mitra.armada.create');
    }

    public function store(Request $request)
    {
        $poBus = Auth::user()->poBus;

        $request->validate([
            'plat_nomor' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'fasilitas' => 'nullable|string',
            'total_kursi' => 'required|integer|min:10|max:60',
        ]);

        $armada = Armada::create([
            'po_bus_id' => $poBus->id,
            'plat_nomor' => $request->plat_nomor,
            'kelas' => $request->kelas,
            'fasilitas' => $request->fasilitas,
            'total_kursi' => $request->total_kursi,
        ]);

        // Auto Generate Kursi Logic
        $kursis = [];
        $cols = ['A', 'B', 'C', 'D'];
        
        $colIdx = 0;
        $rowIdx = 1;

        for ($i = 0; $i < $request->total_kursi; $i++) {
            $kursis[] = [
                'armada_id' => $armada->id,
                'nomor_kursi' => $rowIdx . $cols[$colIdx],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $colIdx++;
            if ($colIdx >= 4) {
                $colIdx = 0;
                $rowIdx++;
            }
        }

        Kursi::insert($kursis);

        return redirect()->route('mitra.armada.index')->with('success', 'Armada berhasil ditambahkan beserta ' . $request->total_kursi . ' nomor kursinya.');
    }

    public function edit(Armada $armada)
    {
        $this->authorizeOwner($armada);
        return view('mitra.armada.edit', compact('armada'));
    }

    public function update(Request $request, Armada $armada)
    {
        $this->authorizeOwner($armada);

        $request->validate([
            'plat_nomor' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'fasilitas' => 'nullable|string',
        ]);

        // Note: Total kursi cannot be simply updated and mapped if tickets exist. 
        // We omit total_kursi update or handle gracefully if wanted. Here we just update metadata.
        $armada->update($request->only('plat_nomor', 'kelas', 'fasilitas'));

        return redirect()->route('mitra.armada.index')->with('success', 'Data armada diperbarui.');
    }

    public function destroy(Armada $armada)
    {
        $this->authorizeOwner($armada);
        $armada->delete();
        return redirect()->route('mitra.armada.index')->with('success', 'Armada dihapus.');
    }

    private function authorizeOwner(Armada $armada)
    {
        if ($armada->po_bus_id !== Auth::user()->poBus->id) {
            abort(403, 'Akses tidak sah.');
        }
    }
}
