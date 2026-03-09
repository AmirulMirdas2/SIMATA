<?php

namespace App\Http\Controllers;

use App\Models\PoBus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminPoBusController extends Controller
{
    public function index()
    {
        $poBuses = PoBus::with('user')->latest()->get();
        return view('admin.po.index', compact('poBuses'));
    }

    public function create()
    {
        return view('admin.po.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_po' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mitra_name' => 'required|string|max:255',
            'mitra_email' => 'required|email|unique:users,email',
            'mitra_password' => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->mitra_name,
                'email' => $request->mitra_email,
                'password' => Hash::make($request->mitra_password),
                'role' => 'mitra',
            ]);

            PoBus::create([
                'user_id' => $user->id,
                'nama_po' => $request->nama_po,
                'deskripsi' => $request->deskripsi,
            ]);
        });

        return redirect()->route('admin.po.index')->with('success', 'PO Bus & Akun Mitra berhasil ditambahkan.');
    }

    public function edit(PoBus $po)
    {
        return view('admin.po.edit', compact('po'));
    }

    public function update(Request $request, PoBus $po)
    {
        $request->validate([
            'nama_po' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $po->update($request->only('nama_po', 'deskripsi'));

        return redirect()->route('admin.po.index')->with('success', 'Data PO Bus berhasil diperbarui.');
    }

    public function destroy(PoBus $po)
    {
        // Because of cascade delete setup in migrations, deleting user will delete their po_bus or vice versa.
        // It's safer to delete the underlying user account to cascade delete the PO.
        $po->user->delete();
        return redirect()->route('admin.po.index')->with('success', 'PO Bus beserta akun mitranya berhasil dihapus.');
    }
}
