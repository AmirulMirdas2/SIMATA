@extends('layouts.app')

@section('title', 'Jadwal Keberangkatan Keberangkatan')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Keberangkatan</h2>
        <a href="{{ route('mitra.jadwal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
            + Tambah Jadwal Baru
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
                    <th class="p-3">Waktu Berangkat</th>
                    <th class="p-3">Armada / Kelas</th>
                    <th class="p-3">Rute Tujuan</th>
                    <th class="p-3">Harga Tiket</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 font-semibold text-blue-900">{{ \Carbon\Carbon::parse($jadwal->waktu_berangkat)->format('d M Y, H:i') }} WIB</td>
                    <td class="p-3">
                        <div class="font-bold">{{ $jadwal->armada->plat_nomor }}</div>
                        <div class="text-xs text-gray-500">{{ $jadwal->armada->kelas }}</div>
                    </td>
                    <td class="p-3 font-semibold text-emerald-700">{{ $jadwal->rute->kota_asal }} &rarr; {{ $jadwal->rute->kota_tujuan }}</td>
                    <td class="p-3 font-semibold text-orange-600">Rp {{ number_format($jadwal->harga_dasar, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('mitra.jadwal.edit', $jadwal->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('mitra.jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Peringatan: Menghapus jadwal akan berdampak pada penumpang yang telah memesan tiket. Lanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada jadwal keberangkatan untuk armada Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
