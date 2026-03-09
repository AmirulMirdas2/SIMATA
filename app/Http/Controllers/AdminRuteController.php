<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use Illuminate\Http\Request;

class AdminRuteController extends Controller
{
    public function index()
    {
        $rutes = Rute::latest()->get();
        return view('admin.rute.index', compact('rutes'));
    }

    public function create()
    {
        return view('admin.rute.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kota_asal' => 'required|string|max:255',
            'kota_tujuan' => 'required|string|max:255',
        ]);

        Rute::create($request->all());

        return redirect()->route('admin.rute.index')->with('success', 'Rute berhasil ditambahkan.');
    }

    public function edit(Rute $rute)
    {
        return view('admin.rute.edit', compact('rute'));
    }

    public function update(Request $request, Rute $rute)
    {
        $request->validate([
            'kota_asal' => 'required|string|max:255',
            'kota_tujuan' => 'required|string|max:255',
        ]);

        $rute->update($request->all());

        return redirect()->route('admin.rute.index')->with('success', 'Rute berhasil diperbarui.');
    }

    public function destroy(Rute $rute)
    {
        $rute->delete();
        return redirect()->route('admin.rute.index')->with('success', 'Rute berhasil dihapus.');
    }
}
