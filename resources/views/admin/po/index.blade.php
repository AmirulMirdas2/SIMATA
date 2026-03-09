@extends('layouts.app')

@section('title', 'Data PO Bus & Mitra')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen PO Bus & Akun Mitra</h2>
        <a href="{{ route('admin.po.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
            + Tambah Mitra PO Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300">
                    <th class="p-3">ID</th>
                    <th class="p-3">Nama PO</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Akun Mitra (Email)</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($poBuses as $po)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $po->id }}</td>
                    <td class="p-3 font-semibold">{{ $po->nama_po }}</td>
                    <td class="p-3 text-sm text-gray-600">{{ Str::limit($po->deskripsi, 50) }}</td>
                    <td class="p-3">
                        <div class="font-medium">{{ $po->user->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $po->user->email ?? 'N/A' }}</div>
                    </td>
                    <td class="p-3 text-center">
                        <a href="{{ route('admin.po.edit', $po->id) }}" class="text-blue-600 hover:underline mr-3">Edit PO</a>
                        <form action="{{ route('admin.po.destroy', $po->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data PO ini beserta akun mitranya? Semua armada dan jadwal terkait juga akan hilang!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada mitra PO Bus yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
