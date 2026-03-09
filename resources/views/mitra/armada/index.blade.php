@extends('layouts.app')

@section('title', 'Data Armada Bus')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Armada Kendaraan</h2>
        <a href="{{ route('mitra.armada.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
            + Tambah Armada
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
                    <th class="p-3">Plat Nomor</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">Kapasitas Kursi</th>
                    <th class="p-3">Fasilitas</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($armadas as $armada)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $armada->id }}</td>
                    <td class="p-3 font-semibold">{{ $armada->plat_nomor }}</td>
                    <td class="p-3">{{ $armada->kelas }}</td>
                    <td class="p-3">{{ $armada->total_kursi }} Kursi</td>
                    <td class="p-3 text-sm text-gray-600">{{ Str::limit($armada->fasilitas, 40) }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('mitra.armada.edit', $armada->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('mitra.armada.destroy', $armada->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Menghapus armada akan menghapus jadwal dan tiket yang terkait. Lanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada armada terdaftar untuk PO Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
